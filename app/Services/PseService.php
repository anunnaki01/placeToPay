<?php

namespace App\Services;

use Pse;

class PseService
{
    protected $pse;

    public function __construct($pseId, $pseKey)
    {
        $this->pse = new Pse;
        $this->pse->services->PseAuth->setLogin($pseId);
        $this->pse->services->PseAuth->setTranKey($pseKey);
    }

    public function getBankList()
    {
        return $this->pse->services->getBankList();
    }
}