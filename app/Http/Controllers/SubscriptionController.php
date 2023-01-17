<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $plan = Plan::whereSlug($request->plan)->first();
        auth()->user()->newSubscription('default', $plan->stripe_id)->create($request->paymentMethodId);
    }
}
