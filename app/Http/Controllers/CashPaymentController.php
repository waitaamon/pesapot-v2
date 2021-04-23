<?php

namespace App\Http\Controllers;

class CashPaymentController extends Controller
{
    public function __invoke()
    {
        return view('cash-payment');
    }
}
