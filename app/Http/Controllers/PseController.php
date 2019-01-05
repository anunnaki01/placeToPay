<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethods;
use App\Models\CustomerTypes;
use App\Models\Transactions;
use Pse;
use App\Services\PseService;
use App\Services\PseValidate;


class PseController extends Controller
{
    protected $pse;
    protected $pseService;

    public function __construct()
    {
        $this->pse = new Pse;
        $this->pseService = new PseService($this->pse);
        $this->pseService->autentication();
    }

    public function index()
    {
        $paymentMethods = PaymentMethods::all();
        $customerTypes = CustomerTypes::all();
        $bankList = $this->pseService->getCacheBankList();

        return view('pse.index', compact('paymentMethods', 'customerTypes', 'bankList'));
    }

    public function createTransaction()
    {
        $PseValidate = new PseValidate();
        $data = request()->validate($PseValidate->getRequiereInputs(), $PseValidate->getMessageInputs());

        $this->pseService->setPayerInformation($data);
        $this->pseService->setTransactionInformation($data);
        $response = $this->pseService->createTransaction();

        if (isset($response['returnCode']) == 'SUCCESS') {

            Transactions::create($response);
            return redirect($response['bankURL']);
        }
    }

    public function transactionInformation($transId)
    {

        $response = $this->pseService->getTransactionInformation($transId);
        dd($response);
    }
}