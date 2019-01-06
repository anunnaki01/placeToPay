<?php

namespace App\Http\Controllers;

use Pse;
use App\Services\PseService;
use Illuminate\Http\Request;
use App\Models\PaymentMethods;
use App\Models\CustomerTypes;

class PseController extends Controller
{
    protected $pse;
    protected $pseService;

    public function __construct()
    {
        $this->middleware('auth');
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
        $data = $this->pseService->validateInputs();
        $this->pseService->setPayerInformation($data);
        $this->pseService->setTransactionInformation($data);

        $response = $this->pseService->createTransaction();

        if (isset($response['returnCode']) && $this->pseService->validateReturnCode($response['returnCode'])) {
            $response['user_id'] = auth()->user()->id;
            $this->pseService->saveTransaction($response);
            return redirect($response['bankURL']);
        }

        return redirect('pse')->with('responseReasonText', $response['responseReasonText'])->withInput();
    }

    public function transactionInformation()
    {
        return redirect('pse/findTransactionInformation/' . session()->pull('transaction_id'));
    }

    public function findTransactionInformation($id)
    {
        $response = $this->pseService->getTransactionInformation($id);

        if (isset($response['getTransactionInformationResult']) && $this->pseService->validateReturnCode($response['getTransactionInformationResult']['returnCode'])) {
            return view('pse.transactionInformation')->with('transactionInformation',
                $response['getTransactionInformationResult']);
        }

        return view('pse.transactionInformation')->with('errorMessage', $response['faultstring']);
    }
}