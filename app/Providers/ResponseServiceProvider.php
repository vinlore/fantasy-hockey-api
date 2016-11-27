<?php

namespace App\Providers;

use Response;

use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('success', function ($status = 200, $data = NULL) {
            switch ($status) {
                case 200:
                    $data = ($data == NULL) ? 'OK' : $data;
                    break;
                case 201:
                    $data = ($data == NULL) ? 'Created' : $data;
                    break;
                case 204:
                    $data = ($data == NULL) ? 'No Content' : $data;
                    break;
            }

            return Response::json([
                'status'  => $status,
                'data' => $data,
            ]);
        });

        Response::macro('error', function ($status = 500, $error = NULL) {
            switch ($status) {
                case 400:
                    $error = ($error == NULL) ? 'Bad Request' : $error;
                    break;
                case 401:
                    $error = ($error == NULL) ? 'Unauthorized' : $error;
                    break;
                case 403:
                    $error = ($error == NULL) ? 'Forbidden' : $error;
                    break;
                case 404:
                    $error = ($error == NULL) ? 'Not Found' : $error;
                    break;
                case 405:
                    $error = ($error == NULL) ? 'Method Not Allowed' : $error;
                    break;
                case 409:
                    $error = ($error == NULL) ? 'Conflict' : $error;
                    break;
                case 422:
                    $error = ($error == NULL) ? 'Unprocessable Entity' : $error;
                    break;
                case 500:
                    $error = ($error == NULL) ? 'Internal Server Error' : $error;
                    break;
            }

            return Response::json([
                'status'  => $status,
                'error' => $error,
            ]);
        });
    }
}
