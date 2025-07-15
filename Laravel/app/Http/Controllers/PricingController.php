<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function pricing()
    {
        return view('pricing');
    }
}
