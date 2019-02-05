<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('success', function ($data, $status) {
            return Response::json($data, $status);
        });
        
        Response::macro('error', function ($title, $message, $status) {
            return Response::json([
                'errors'  => true,
                'title' => $title,
                'message' => $message
            ], $status);
        });
    }
    
}
