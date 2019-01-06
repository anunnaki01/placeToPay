<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

use Pse;
use Session;
use App\Models\Transactions;

class PseService
{
    public function __construct(Pse $pse)
    {
        $this->pse = $pse;
    }

    public function autentication()
    {
        $this->pse->services->PseAuth->setLogin(env("PSE_IDENTIFICATION"));
        $this->pse->services->PseAuth->setTranKey(env("PSE_KEY"));
    }

    public function createTransaction()
    {
        return $this->pse->services->createTransaction();
    }

    public function getTransactionInformation($transId)
    {
        $this->pse->services->setTransId($transId);
        return $this->pse->services->getTransactionInformation();
    }

    public function setPayerInformation(array $data)
    {
        $this->pse->services->setPlayerDocumentType($data['documentType']);
        $this->pse->services->setPlayerDocument($data['document']);
        $this->pse->services->setPlayerFirstName($data['firstName']);
        $this->pse->services->setPlayerLastName($data['lastName']);
        $this->pse->services->setPlayerCompany($data['company']);
        $this->pse->services->setPlayerEmailAddress($data['emailAddress']);
        $this->pse->services->setPlayerCity($data['city']);
        $this->pse->services->setPlayerProvince($data['province']);
        $this->pse->services->setPlayerAddress($data['address']);
        $this->pse->services->setPlayerPhone($data['phone']);
        $this->pse->services->setPlayerCountry($data['country']);
        $this->pse->services->setPlayerMobile($data['mobile']);
        $this->pse->services->infoPlayer();
    }

    public function setTransactionInformation(array $data)
    {
        $this->pse->services->setBankCode($data['bankCode']);
        $this->pse->services->setBankInterface($data['bankInterface']);
        $this->pse->services->setReturnURL(env('PSE_RETURN_URL'));
        $this->pse->services->setReference('kad2568994dasuudadsasaassasss');
        $this->pse->services->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut');
        $this->pse->services->setLanguage(env("PSE_LANGUAGE"));
        $this->pse->services->setCurrency(env("PSE_CURRENCY"));
        $this->pse->services->setTotalAmount((double)env("PSE_TOTAL_AMOUNT"));
        $this->pse->services->setTaxAmount((double)env("PSE_TAX_AMOUNT"));
        $this->pse->services->setDevolutionBase((double)env("PSE_DEVOLUTION_BASE"));
        $this->pse->services->setTipAmount((double)env("PSE_TIP_AMOUNT"));
    }

    public function getCacheBankList()
    {
        $bankList = Cache::get('bankList');

        if (!Cache::has('bankList') || is_string($bankList)) {

            $bankList = $this->pse->services->getBankList();

            if (isset($bankList['getBankListResult']['item']) && !empty($bankList['getBankListResult']['item'])) {
                $bankList = $bankList['getBankListResult']['item'];
            } else {
                $bankList = "No se pudo obtener la lista de Entidades Financieras, por favor intente más tarde";
            }

            Cache::put('bankList', $bankList, 1440);
        }

        return Cache::get('bankList');
    }

    public function validateInputs()
    {
        $PseValidate = new PseValidate();
        return $PseValidate->validateInputs();
    }

    public function saveTransaction($response)
    {
        $transaction = Transactions::where('transaction_id', $response['transactionID'])->first();

        if (!empty($transaction)) {


            $transaction->reference = $response['reference'];
            $transaction->transaction_state = $response['transactionState'];
            $transaction->request_date = $response['requestDate'];
            $transaction->bank_process_date = $response['bankProcessDate'];
            $transaction->description = utf8_encode($response['responseReasonText']);

            return $transaction->save();
        }


        $data['transaction_id'] = $response['transactionID'];
        $data['session_id'] = $response['sessionID'];
        $data['request_date'] = null;
        $data['bank_process_date'] = null;
        $data['description'] = utf8_encode($response['responseReasonText']);
        $data['reference'] = null;
        $data['trazability_code'] = $response['trazabilityCode'];
        $data['transaction_state'] = 'PENDING';
        $data['user_id'] = $response['user_id'];

        return Transactions::create($data);
    }

    public function getTransaction($transaction_id)
    {
        return Transactions::where('transaction_id', $transaction_id)->first();
    }

    public function validateReturnCode($returnCode)
    {
        $PseValidate = new PseValidate();
        return $PseValidate->validateReturnCode($returnCode);
    }

    public function getRedirectTransaction($response)
    {
        if (isset($response['returnCode']) && $this->validateReturnCode($response['returnCode'])) {
            $response['user_id'] = auth()->user()->id;
            session(['transaction_id' => $response['transactionID']]);
            $this->saveTransaction($response);
            return redirect($response['bankURL']);
        }

        return redirect('pse')->with('responseReasonText', $response['responseReasonText'])->withInput();
    }

    public function getTransactionsByUser()
    {
        return Transactions::where('user_id', auth()->user()->id)->get();
    }
}