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

$router->group([
    'prefix' => 'api'
], function () use ($router) {
    $router->post('/login', 'AuthController@Login');
    $router->post('/register', 'AuthController@Register');

    $router->group([
        'prefix' => '/checklist'
    ], function () use ($router) {
        $router->get('/', 'ChecklistController@GetAllChecklist');
        $router->post('/', 'ChecklistController@CreateChecklist');
        $router->delete('/{id}', 'ChecklistController@DeleteChecklist');
    });

    $router->group([
        'prefix' => '/checklist/{checklistId}/item'
    ], function () use ($router) {
        $router->get('/', 'ChecklistController@GetAllChecklistItem');
        $router->post('/', 'ChecklistController@CreateChecklistItem');
        $router->get('/{id}', 'ChecklistController@GetChecklistItemDetail');
        $router->put('/{id}', 'ChecklistController@UpdateChecklistItemDetail');
        $router->delete('/{id}', 'ChecklistController@DeleteChecklistItem');
        $router->put('/rename/{id}', 'ChecklistController@RenameChecklistItemDetail');
    });
});
