<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

// prefix api

$router->get('/email/verify/{user}/{hash}', 'EmailController@confirmation');
$router->post('/email/verify/resend', 'EmailController@resend');

// Auth User
$router->post('/user/login', 'AuthController@login');
$router->post('/user/register', 'AuthController@register');

// User
$router->group(['middleware' => ['jwt', 'auth', 'verified'], 'prefix' => 'user'], function () use ($router) {
    $router->get('/', 'UserController@show');
});
