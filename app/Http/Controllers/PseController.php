<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pse;


class PseController extends Controller
{
    public function index()
    {
        $pse = new Pse;
        echo dd($pse->services->getBankList());
    }
}
