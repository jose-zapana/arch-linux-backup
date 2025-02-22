<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index()
    {   
        $addresses = auth()->user()->addresses;
        return view('shipping.index', compact('addresses'));
    }
}
