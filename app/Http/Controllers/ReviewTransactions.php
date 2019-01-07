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

    public function index()
    {
        $transactions = Transactions::where('transaction_state', 'PENDING')->get();

        foreach ($transactions as $transaction) {
            $response = $this->pseService->getTransactionInformation($transaction->transaction_id);
            if (!empty($response['getTransactionInformationResult'])) {
                dd($response);
                $this->pseService->saveTransaction($response['getTransactionInformationResult']);
            }
        }

        return redirect()->back();
    }
}
