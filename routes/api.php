<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function($api){

    $api->group(['middleware' => ['throttle:60,1', \Illuminate\Routing\Middleware\SubstituteBindings::class], 'namespace' => 'App\Http\Controllers'], function($api) {

        $api->get('ping', 'Api\PingController@index');
        $api->get('rolelist', 'Api\PingController@getRoles');

        $api->get('assets/{uuid}/render', 'Api\Assets\RenderFileController@show');

        $api->group(['prefix' => 'auth'], function ($api) {
            $api->post('/', 'Api\Auth\ApiAuthController@login');
            $api->post('/register', 'Api\Auth\ApiAuthController@register');
            $api->post('/forgotpassword', 'Api\Auth\ApiAuthController@forgotPassword');           
        });

        $api->group(['middleware' => ['auth:api'], ], function ($api) {
            $api->group(['prefix' => 'auth'], function ($api) {
                $api->get('/me', 'Api\Auth\ApiAuthController@getCurrentUserInfo');                       
                $api->post('/logout', 'Api\Auth\ApiAuthController@logout');                       
            });
        });

        $api->group(['middleware' => ['auth:api'], ], function ($api) {

            $api->group(['prefix' => 'users'], function ($api) {
                $api->get('/', 'Api\Users\UsersController@index');
                $api->get('/{id}', 'Api\Users\UsersController@show');
                $api->post('/', 'Api\Users\UsersController@store');
                
                $api->put('/{id}', 'Api\Users\UsersController@user_update');
                
                //$api->put('/{id}', 'Api\Users\UsersController@update');
                //$api->patch('/{id}', 'Api\Users\UsersController@update');
                $api->delete('/{id}', 'Api\Users\UsersController@destroy');
            });

            $api->group(['prefix' => 'customers'], function ($api) {
                $api->get('/', 'Api\CustomerManagementController@index');
                $api->get('/orders/{id}', 'Api\CustomerManagementController@getOrders');

                $api->post('/', 'Api\CustomerManagementController@store');

                $api->put('/{id}', 'Api\CustomerManagementController@update');  
                $api->patch('/{id}', 'Api\CustomerManagementController@update');
            });

            $api->group(['prefix' => 'orders'], function ($api) {
                $api->get('/', 'Api\OrderManagementController@index');

                $api->get('/report/years', 'Api\OrderManagementController@getYearsForReport');
                $api->get('/report/revenue', 'Api\OrderManagementController@getRevenueForReport');
                $api->get('/report/profit', 'Api\OrderManagementController@getProfitForReport');

                $api->post('/', 'Api\OrderManagementController@store');

                $api->post('/agreement', 'Api\OrderManagementController@saveAgreement');
                $api->post('/agreement/profit', 'Api\OrderManagementController@saveProfitAndRevenue');
                $api->post('/payment/manual', 'Api\OrderManagementController@savePaymentHistory');
                
                $api->post('/status', 'Api\OrderManagementController@setOrderStatus');
                
                $api->post('/metafirst', 'Api\OrderManagementController@updateMetaFirst');
                $api->post('/metasecond', 'Api\OrderManagementController@updateMetaSecond');
                $api->post('/metathird', 'Api\OrderManagementController@updateMetaThird');
                $api->post('/metaforth', 'Api\OrderManagementController@updateMetaForth');

                $api->delete('/delete/{id}', 'Api\OrderManagementController@deleteOrder');
            });

            $api->group(['prefix' => 'products'], function ($api) {
                $api->get('/', 'Api\ProductManagementController@index');
        
            });
        
            $api->group(['prefix' => 'me'], function($api) {
                $api->get('/', 'Api\Users\ProfileController@index');
                $api->put('/', 'Api\Users\ProfileController@update');
                $api->patch('/', 'Api\Users\ProfileController@update');
                $api->put('/password', 'Api\Users\ProfileController@updatePassword');
            });

            $api->group(['prefix' => 'assets'], function($api) {
                $api->post('/', 'Api\Assets\UploadFileController@fileUploadPost');
                
                            
            });

        });

    });

});



