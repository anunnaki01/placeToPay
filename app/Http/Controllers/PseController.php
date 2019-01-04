<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethods;
use App\Models\CustomerTypes;
use Illuminate\Support\Facades\Cache;


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
        $bankList = $this->getCacheBankList();

        return view('pse.index', compact('paymentMethods', 'customerTypes', 'bankList'));
    }

    private function getCacheBankList()
    {
        $bankList = Cache::get('bankList');

        if (!Cache::has('bankList') || is_string($bankList)) {

            $bankList = $this->pse->getBankList();

            if (isset($bankList['getBankListResult']['item']) && !empty($bankList['getBankListResult']['item']))
                $bankList = $bankList['getBankListResult']['item'];
            else
                $bankList = "No se pudo obtener la lista de Entidades Financieras, por favor intente más tarde";

            Cache::put('bankList', $bankList, 1440);
        }

        return Cache::get('bankList');
    }
}