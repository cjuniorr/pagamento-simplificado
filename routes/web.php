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

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['prefix' => '/api'], function($router) {
    $router->get('series', 'SeriesController@index');
    
    $router->post('user', 'UserController@Add');
    $router->get('user', 'UserController@GetAll');
    $router->get('user/{id}', 'UserController@Get');
    $router->delete('user/{id}', 'UserController@Remove');

    $router->get('transaction', 'TransactionController@GetAll');
    $router->post('transaction', 'TransactionController@Add');
    $router->get('transaction', 'TransactionController@GetAll');
    $router->get('transaction/{id}', 'TransactionController@Get');
    $router->delete('transaction/{id}', 'TransactionController@Remove');
});