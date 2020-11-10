<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Support\Arr;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $function = function ($value, array $parameters, array $rules) {

            if (!is_string($value) && !(is_object($value) && method_exists($value, '__toString'))) {
                return false;
            }

            $parameters = collect($parameters)->unique();

            if ($parameters->count()) {
                $rules = Arr::only($rules, $parameters->toArray());
            }

            foreach ($rules as $rule) {
                if (preg_match($rule, $value)) {
                    return true;
                }
            }

            return false;
        };

        ValidatorFacade::extend('phone_number', function (
            string $attribute, $value, array $parameters, Validator $validator
        ) use ($function) : bool {
            return $function($value, $parameters, [
                'AU' => '^(?:\+?(61))? ?(?:\((?=.*\)))?(0?[2-57-8])\)? ?(\d\d(?:[- ](?=\d{3})|(?!\d\d[- ]?\d[- ]))\d\d[- ]?\d[- ]?\d{3})$',
            ]);
        });
    }
}
