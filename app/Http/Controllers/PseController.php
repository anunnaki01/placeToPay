<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethods;
use App\Models\CustomerTypes;


class PseController extends Controller
{
    protected $pse;

    public function __construct()
    {
        $this->pse = new \App\Services\PseService(env("PSE_IDENTIFICATION"), env("PSE_KEY"));
    }

    public function index()
    {
        $paymentMethods = PaymentMethods::all();
        $customerTypes = CustomerTypes::all();
        $bankList = $this->pse->getBankList();

        if(isset($bankList['getBankListResult']['item']) && !empty($bankList['getBankListResult']['item']))
            $bankList = $bankList['getBankListResult']['item'];

        return view('pse.index', compact('paymentMethods', 'customerTypes','bankList'));
    }
}