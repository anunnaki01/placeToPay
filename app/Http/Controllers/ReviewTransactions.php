<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pse;
use App\Services\PseService;

use App\Models\Transactions;

class ReviewTransactions extends Controller
{
    public function __construct()
    {
        $this->pse = new Pse;
        $this->pseService = new PseService($this->pse);
    }

    public function process()
    {
        $transactions = Transactions::where('transaction_state', 'PENDING')->get();
        $transactionsProcesed = ['status' => false];

        if ($transactions->count() == 0) {
            $transactionsProcesed['message'] = 'No hay transacciones pendientes...';
            return $transactionsProcesed;
        }

        $transactionsProcesed['status'] = true;

        foreach ($transactions as $transaction) {

            $response = $this->pseService->getTransactionInformation($transaction->transaction_id);

            if (!empty($response['getTransactionInformationResult'])) {
                $transactionsProcesed['transactions'][] = $response['getTransactionInformationResult']['transactionID'];
                $this->pseService->saveTransaction($response['getTransactionInformationResult']);
            }
        }
        return $transactionsProcesed;
    }

    public function index()
    {
        return redirect('transactions')->with('transactionsProcesed', $this->process());
    }
}
