<?php

namespace App\Http\Controllers\Api\Assets;

use App\Events\AssetWasCreated;
use App\Exceptions\BodyTooLargeException;
use App\Http\Controllers\Controller;
use App\Transformers\Assets\AssetTransformer;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\PaymentHistory;
use App\Models\Agreement;

/**
 * Class UploadFileController.
 */
class UploadFileController extends Controller
{
    use Helpers;

    /**
     * @var array
     */
    protected $validMimes = [
        'image/jpeg' => [
            'type' => 'image',
            'extension' => 'jpeg',
        ],
        'image/jpg' => [
            'type' => 'image',
            'extension' => 'jpg',
        ],
        'image/png' => [
            'type' => 'image',
            'extension' => 'png',
        ],
    ];

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var \App\Models\Asset
     */
    protected $model;

    /**
     * UploadFileController constructor.
     *
     * @param \GuzzleHttp\Client $client
     * @param \App\Models\Asset $model
     */
    public function __construct(Client $client, \App\Models\Asset $model)
    {
        $this->client = $client;
        $this->model = $model;
    }

    public function fileUploadPost(Request $request)
    {
        $request->validate([
            'file' => 'required|max:100000',
            'category' => 'required'
        ]);
        //return response($request->all());  
        $fileName = time().'.'.$request->file->extension();  
        
        if($request->category == 'payment-1') {
            $request->file->move(public_path('uploads/centrepay'), $fileName);
            
            $file = public_path('uploads/centrepay/' . $fileName);
            $paymentBulkArr = $this->csvToArray($file);
            
            foreach ($paymentBulkArr as $paymentBulk) {
                $agreement = Agreement::where('meta_key', $paymentBulk[2])->first();
                if($agreement != null) {
                    //return response(["test" => (float)substr($paymentBulk[3], 1)]);
                    $data = [
                        'date' => date('Y-m-d', strtotime($paymentBulk[5])),
                        'customer_id' => $agreement->customer_id,
                        'order_id' => $agreement->order_id,
                        'paid_amount' => (float)substr($paymentBulk[3], 1),
                        'payment_method' => 1,
                        'is_contract' => 0,
                    ];

                    PaymentHistory::create($data);
                }
            }
            //return response($customerArr);
        }
        else if($request->category == 'payment-2')
            $request->file->move(public_path('uploads/ezi-debit'), $fileName);
        else
            $request->file->move(public_path('uploads/customers'), $fileName);

        return response(['filename' => $fileName]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return $this
     */
    public function store(Request $request)
    {
        if ($request->isJson()) {
            $asset = $this->uploadFromUrl([
                'url' => $request->get('url'),
                'user' => $request->user(),
            ]);
        } elseif ($request->hasFile('file')) {
            $file = $request->file('file')->getRealPath();
            $asset = $this->uploadFromDirectFile([
                'mime' => $request->file('file')->getClientMimeType(),
                'content' => file_get_contents($file),
                'Content-Length' => $request->header('Content-Length'),
                'user' => $request->user(),
            ]);
        } else {
            $body = ! (base64_decode($request->getContent())) ? $request->getContent() : base64_decode($request->getContent());
            $asset = $this->uploadFromDirectFile([
                'mime' => $request->header('Content-Type'),
                'content' => $body,
                'Content-Length' => $request->header('Content-Length'),
                'user' => $request->user(),
            ]);
        }

        event(new AssetWasCreated($asset));

        return $this->response->item($asset, new AssetTransformer())->setStatusCode(201);
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    protected function uploadFromDirectFile($attributes = [])
    {
        $this->validateMime($attributes['mime']);
        $this->validateBodySize($attributes['Content-Length'], $attributes['content']);
        $path = $this->storeInFileSystem($attributes);

        return $this->storeInDatabase($attributes, $path);
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    protected function uploadFromUrl($attributes = [])
    {
        $response = $this->callFileUrl($attributes['url']);
        $attributes['mime'] = $response->getHeader('content-type')[0];
        $this->validateMime($attributes['mime']);
        $attributes['content'] = $response->getBody();
        $path = $this->storeInFileSystem($attributes);

        return $this->storeInDatabase($attributes, $path);
    }

    /**
     * @param array $attributes
     * @param $path
     * @return mixed
     */
    protected function storeInDatabase(array $attributes, $path)
    {
        $file = $this->model->create([
            'type' => $this->validMimes[$attributes['mime']]['type'],
            'path' => $path,
            'mime' => $attributes['mime'],
            'user_id' => ! empty($attributes['user']) ? $attributes['user']->id : null,
        ]);

        return $file;
    }

    /**
     * @param array $attributes
     * @return string
     */
    protected function storeInFileSystem(array $attributes)
    {
        $path = md5(Str::random(16).date('U')).'.'.$this->validMimes[$attributes['mime']]['extension'];
        Storage::put($path, $attributes['content']);

        return $path;
    }

    /**
     * @param $url
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function callFileUrl($url)
    {
        try {
            return $this->client->get($url);
        } catch (TransferException $e) {
            throw new StoreResourceFailedException('Validation Error', [
                'url' => 'The url seems to be unreachable: '.$e->getCode(),
            ]);
        }
    }

    /**
     * @param $mime
     */
    protected function validateMime($mime)
    {
        if (! array_key_exists($mime, $this->validMimes)) {
            throw new StoreResourceFailedException('Validation Error', [
                'Content-Type' => 'The Content Type sent is not valid',
            ]);
        }
    }

    /**
     * @param $contentLength
     * @param $content
     * @throws \App\Exceptions\BodyTooLargeException
     */
    protected function validateBodySize($contentLength, $content)
    {
        if ($contentLength > config('files.maxsize', 1000000) || mb_strlen($content) > config('files.maxsize', 1000000)) {
            throw new BodyTooLargeException();
        }
    }

    function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                //if (!$header)
                //    $header = $row;
                //else
                        $data[] = $row;
            }
            fclose($handle);
        }

        return $data;
    }
}
