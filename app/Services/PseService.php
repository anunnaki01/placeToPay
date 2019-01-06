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
        $this->pse->services->setReturnURL('http://placetopay.local.com/pse/transactionInformation');
        $this->pse->services->setReference('kad2568994dasuudadsasaassasss');
        $this->pse->services->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut');
        $this->pse->services->setLanguage('es');
        $this->pse->services->setCurrency('COP');
        $this->pse->services->setTotalAmount(15000.0);
        $this->pse->services->setTaxAmount((double)5);
        $this->pse->services->setDevolutionBase(2.0);
        $this->pse->services->setTipAmount(1.0);
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
        session(['transaction_id' => $response['transactionID']]);

        $data['transaction_id'] = $response['transactionID'];
        $data['session_id'] = $response['sessionID'];
        $data['reference'] = null;
        $data['trazability_code'] = $response['trazabilityCode'];
        $data['transaction_state'] = 'PENDING';
        $data['user_id'] = $response['user_id'];

        Transactions::create($data);

        return redirect($response['bankURL']);
    }

    public function validateReturnCode($returnCode)
    {
        $PseValidate = new PseValidate();
        return $PseValidate->validateReturnCode($returnCode);
    }

}