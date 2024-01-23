<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/login', AuthController::Login);
    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->get('/', function () {
            // Uses Auth Middleware
        });

        $router->get('user/profile', function () {
            // Uses Auth Middleware
        });
    });
});
