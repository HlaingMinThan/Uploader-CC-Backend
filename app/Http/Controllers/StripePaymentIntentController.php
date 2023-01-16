<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripePaymentIntentController extends Controller
{
    public function __invoke(Request $request)
    {
        return [
            'client_secret' => $request->user()->createSetupIntent()->client_secret
        ];
    }
}
