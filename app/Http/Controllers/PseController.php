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

        return $this->pseService->getRedirectTransaction($response);
    }

    public function transactionInformation()
    {
        $transaction_id = session()->pull('transaction_id');
        $response = $this->pseService->getTransactionInformation($transaction_id);

        if (!empty($response['getTransactionInformationResult'])) {
            $this->pseService->saveTransaction($response['getTransactionInformationResult']);
            return redirect()->route('details.transaction', ['id' => $transaction_id]);
        }

        return view('pse.transactionInformation')->with('errorMessage', $response['faultstring']);
    }

    public function findTransactionInformation($transaction_id)
    {
        $transaction = $this->pseService->getTransaction($transaction_id);
        return view('pse.transactionInformation')->with('transactionInformation', $transaction);
    }

    public function transactions()
    {
        $transactions = $this->pseService->getTransactionsByUser();
        return view('pse.transactions', compact('transactions'));
    }
}