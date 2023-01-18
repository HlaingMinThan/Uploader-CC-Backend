<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Exception;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $plan = Plan::whereSlug($request->plan)->first();
        auth()->user()->newSubscription('default', $plan->stripe_id)->create($request->paymentMethodId);
    }

    public function update(Request $request)
    {
        $plan = Plan::whereSlug($request->plan)->first();

        if (!$request->user()->canSwap($plan)) {
            throw new Exception("you can't swap this plan.");
        }
        //if plan is free,cancel the subscription
        if (!$plan->buyable) {
            auth()->user()->subscription('default')->cancel();
            return;
        }
        auth()->user()->subscription('default')->swapAndInvoice($plan->stripe_id);
    }
}
