<?php

namespace App\Providers;

use Validator;
use App\Services\Validation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 手机号验证规则
        Validator::extend('cn_phone', function ($attribute, $value, $parameters) {
            return preg_match('/^1[34578][0-9]{9}$/', $value);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
