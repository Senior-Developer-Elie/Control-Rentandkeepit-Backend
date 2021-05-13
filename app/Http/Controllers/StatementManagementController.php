<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use PDF;

class StatementManagementController extends Controller
{
    public function generatePDF($id)
    {
        $pdf = PDF::loadView('statement');
        return $pdf->download('statement.pdf');
    }
}
