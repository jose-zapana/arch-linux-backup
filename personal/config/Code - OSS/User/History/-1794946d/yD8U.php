<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Http\Middleware\VerifyStock;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;  // Asegúrate de que esté importado correctamente.

class CartController extends BaseController
{
    public function __construct()
    {
        $this->middleware(VerifyStock::class);
    }

    public function index()
    {
        return view('cart.index');
    }
}

