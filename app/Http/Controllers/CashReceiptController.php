<?php

namespace App\Http\Controllers;

class CashReceiptController extends Controller
{
    public function __invoke()
    {
        return view('cash-receipt');
    }
}
