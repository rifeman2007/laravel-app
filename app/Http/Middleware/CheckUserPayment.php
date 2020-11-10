<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CheckUserPayment
{
    private $excludeRoutes = [
        'payment',
        'payment.post',
    ];
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if (!Auth::user()->hasPaymentMethod() && !in_array(Route::currentRouteName(), $this->excludeRoutes)) {
                return redirect('payment');
            }
        }    

        return $next($request);
    }
}
