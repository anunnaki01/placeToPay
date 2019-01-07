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

        if ($transactions->count() == 0) {
            echo 'No hay transacciones para procesar';
            return false;
        }
        echo "<b>Transacciones procesadas: </b><br>";
        foreach ($transactions as $transaction) {
            $response = $this->pseService->getTransactionInformation($transaction->transaction_id);

            if (!empty($response['getTransactionInformationResult'])) {
                echo $response['getTransactionInformationResult']['transactionID'] . "<br>";
                $this->pseService->saveTransaction($response['getTransactionInformationResult']);
            }
        }
    }
}
