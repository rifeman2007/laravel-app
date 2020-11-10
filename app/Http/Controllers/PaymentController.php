<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * @param Request $request
     */
    public function index(Request $request)
    {
        if (Gate::inspect('payment')->allowed()) {
            return redirect('dashboard');
        }
        
        return view('payment.index');
    }

    /**
     * @param Request $request
     */
    public function paymentMethod(Request $request)
    {
        try {
            $user = Auth::user();

            $user->createOrGetStripeCustomer();    
            $user->addPaymentMethod($request->get('payment_method_id'));

            return Response::json(['success' => true]);
        } catch (\Exception $e) {
            return Response::json(['success' => false, 'error' => ['message' => $e->getMessage()]]);
        }           
    }
}