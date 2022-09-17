<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ApiResponseServiceProvider extends ServiceProvider
{

    const STATUS_SUCCESS = 'success';
    const STATUS_FAILED = 'failed';



    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        response()->macro('api', function ($data, $state = 'success', $message = [], $code = 200) {

            if (!is_array($message)) {
                $message = [$message];
            }
            if (empty($data)) {
                return $this->json([
                    'status' => (string)$state,
                    'message' => $message,
                    'code' => $code,
                ], $code);
            }
            return $this->json([
                'status' => (string)$state,
                'message' => $message,
                'code' => $code,
                'data' => (object)$data,
            ], $code);
        });
    }
}
