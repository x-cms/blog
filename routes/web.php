<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your Module. Just tell Your app the URIs it should respond to
| using a Closure or controller method. Build something great!
|
*/

use Illuminate\Routing\Router;

Route::group(['prefix' => 'admin', 'middleware' => 'auth.admin'], function (Router $router) {
    $router->group(['prefix' => 'posts'], function (Router $router) {
        $router->get('', 'PostController@index')
            ->name('posts.index')
            ->middleware('has-permission:view-posts');

        $router->post('', 'PostController@index')
            ->name('posts.index')
            ->middleware('has-permission:view-posts');

        $router->get('create', 'PostController@create')
            ->name('posts.create')
            ->middleware('has-permission:create-posts');

        $router->post('create', 'PostController@store')
            ->name('posts.store')
            ->middleware('has-permission:create-posts');

        $router->get('edit/{id}', 'PostController@edit')
            ->name('posts.edit')
            ->middleware('has-permission:edit-posts');

        $router->post('edit/{id}', 'PostController@update')
            ->name('posts.update')
            ->middleware('has-permission:edit-posts');

        $router->delete('{id}', 'PostController@destroy')
            ->name('posts.destroy')
            ->middleware('has-permission:delete-posts');
    });

    $router->group(['prefix' => 'categories'], function (Router $router) {
        $router->get('', 'CategoryController@index')
            ->name('categories.index')
            ->middleware('has-permission:view-categories');

        $router->post('', 'CategoryController@index')
            ->name('categories.index')
            ->middleware('has-permission:view-categories');

        $router->get('create', 'CategoryController@create')
            ->name('categories.create')
            ->middleware('has-permission:create-categories');

        $router->post('create', 'CategoryController@store')
            ->name('categories.store')
            ->middleware('has-permission:create-categories');

        $router->get('edit/{id}', 'CategoryController@edit')
            ->name('categories.edit')
            ->middleware('has-permission:edit-categories');

        $router->post('edit/{id}', 'CategoryController@update')
            ->name('categories.update')
            ->middleware('has-permission:edit-categories');

        $router->delete('{id}', 'CategoryController@destroy')
            ->name('categories.destroy')
            ->middleware('has-permission:delete-categories');

        $router->get('reorder', 'CategoryController@reorder')
            ->name('categories.reorder')
            ->middleware('has-permission:reorder-categories');

        $router->post('reorder', 'CategoryController@reorder')
            ->name('categories.reorder')
            ->middleware('has-permission:reorder-categories');
    });

    $router->group(['prefix' => 'tags'], function (Router $router) {
        $router->get('', 'TagController@index')
            ->name('tags.index')
            ->middleware('has-permission:view-tags');

        $router->post('', 'TagController@index')
            ->name('tags.index')
            ->middleware('has-permission:view-tags');

        $router->get('create', 'TagController@create')
            ->name('tags.create')
            ->middleware('has-permission:create-tags');

        $router->post('create', 'TagController@store')
            ->name('tags.store')
            ->middleware('has-permission:create-tags');

        $router->get('edit/{id}', 'TagController@edit')
            ->name('tags.edit')
            ->middleware('has-permission:edit-tags');

        $router->post('edit/{id}', 'TagController@update')
            ->name('tags.update')
            ->middleware('has-permission:edit-tags');

        $router->delete('{id}', 'TagController@destroy')
            ->name('tags.destroy')
            ->middleware('has-permission:delete-tags');
    });
});