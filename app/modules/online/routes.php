<?php

// Module enabled;
$json = Helper::getJsonFile(__DIR__ . '/module.json');

if ($json['enabled']) {

    $configModule = Config::get('online::module', array());
    extract($configModule);

    // Admin online routes
    Route::group(array("prefix" => "admin", "before" => "admin"), function () use ($moduleUpper, $moduleLower, $moduleAdminRoute) {

        // Online
        Route::get($moduleAdminRoute, array("as" => "admin.{$moduleAdminRoute}.index", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@index"));

        Route::get("{$moduleAdminRoute}/{id}/edit", array("as" => "admin.{$moduleAdminRoute}.edit", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@edit"));

        Route::get("{$moduleAdminRoute}/{id}/destroy", array("as" => "admin.{$moduleAdminRoute}.destroy", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@destroy"));

        Route::get("{$moduleAdminRoute}/create", array("as" => "admin.{$moduleAdminRoute}.create", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@create"));

        Route::post($moduleAdminRoute, array("as" => "admin.{$moduleAdminRoute}.store", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@store"));

        Route::put("{$moduleAdminRoute}/{id}", array("as" => "admin.{$moduleAdminRoute}.update", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@update"));

        Route::get("{$moduleAdminRoute}/image/{id}/destroy", array("as" => "admin.{$moduleAdminRoute}.image.destroy", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@destroyImage"));

        Route::get("api/{$moduleAdminRoute}/dt", array("as" => "api.{$moduleAdminRoute}.dt", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@getDatatable"));

        Route::get("api/{$moduleAdminRoute}/tags", array("as" => "api.{$moduleAdminRoute}.tags", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@getTags"));

        // Online Category
        $subModules = Config::get('online::subModules', array());
        $subModule = $subModules['category'];
        $subModule['moduleAdminRoute'] = 'online-category';

        Route::get($subModule['moduleAdminRoute'], array("as" => "admin.{$subModule['moduleAdminRoute']}.index", "uses" => $moduleUpper . '\Admin\Controllers\\' . "CategoryController@index"));

        Route::get("{$subModule['moduleAdminRoute']}/{id}/edit", array("as" => "admin.{$subModule['moduleAdminRoute']}.edit", "uses" => $moduleUpper . '\Admin\Controllers\\' . "CategoryController@edit"));

        Route::get("{$subModule['moduleAdminRoute']}/{id}/destroy", array("as" => "admin.{$subModule['moduleAdminRoute']}.destroy", "uses" => $moduleUpper . '\Admin\Controllers\\' . "CategoryController@destroy"));

        Route::get("{$subModule['moduleAdminRoute']}/create", array("as" => "admin.{$subModule['moduleAdminRoute']}.create", "uses" => $moduleUpper . '\Admin\Controllers\\' . "CategoryController@create"));

        Route::post("{$subModule['moduleAdminRoute']}", array("as" => "admin.{$subModule['moduleAdminRoute']}.store", "uses" => $moduleUpper . '\Admin\Controllers\\' . "CategoryController@store"));

        Route::put("{$subModule['moduleAdminRoute']}/{id}", array("as" => "admin.{$subModule['moduleAdminRoute']}.update", "uses" => $moduleUpper . '\Admin\Controllers\\' . "CategoryController@update"));

        Route::get("{$subModule['moduleAdminRoute']}/image/{id}/destroy", array("as" => "admin.{$subModule['moduleAdminRoute']}.image.destroy", "uses" => $moduleUpper . '\Admin\Controllers\\' . "CategoryController@destroyImage"));

        Route::get("api/{$subModule['moduleAdminRoute']}/dt", array("as" => "api.{$subModule['moduleAdminRoute']}.dt", "uses" => $moduleUpper . '\Admin\Controllers\\' . "CategoryController@getDatatable"));

        Route::get("{$subModule['moduleAdminRoute']}/order", array("as" => "admin.{$subModule['moduleAdminRoute']}.order", "uses" => $moduleUpper . '\Admin\Controllers\\' . "CategoryController@order"));

        Route::get("api/{$subModule['moduleAdminRoute']}/tree", array("as" => "api.{$subModule['moduleAdminRoute']}.gettree", "uses" => $moduleUpper . '\Admin\Controllers\\' . "CategoryController@getTree"));

        Route::post("api/{$subModule['moduleAdminRoute']}/tree", array("as" => "api.{$subModule['moduleAdminRoute']}.posttree", "uses" => $moduleUpper . '\Admin\Controllers\\' . "CategoryController@postTree"));
    });

    // Front online routes
//    Route::get("{$moduleLower}/{slug}", array("as" => "{$moduleLower}.show", "uses" => $moduleUpper . '\Controllers\\' . "{$moduleUpper}Controller@show"));
    Route::get("{slug}", array("as" => "{$moduleLower}.show", "uses" => $moduleUpper . '\Controllers\\' . "{$moduleUpper}Controller@show"));

    Route::post("{$moduleLower}/process/{id}", array("as" => "{$moduleLower}.process", "uses" => $moduleUpper . '\Controllers\\' . "{$moduleUpper}Controller@process"));

    Route::get("{$moduleLower}", array("as" => "{$moduleLower}.index", "uses" => $moduleUpper . '\Controllers\\' . "{$moduleUpper}Controller@index"));

    Route::get("game/{slug}", array("as" => "game.show", "uses" => $moduleUpper . '\Controllers\\' . "{$moduleUpper}Controller@gameShow"));

    // Menu
    $data = View::make("{$moduleLower}::admin.menu", $configModule);
    Helper::Collector("menu", $data, $json['order']);

}

// View composer
View::composer('front::_partials.sidebar', function($view)
{
    $viewData= $view->getData();
    $sidebar = isset($viewData['sidebar']) ? $viewData['sidebar'] : array();
    $sidebar = View::make("online::front._partials.sidebar", array('categories' => Online\Models\Category::roots()->get()));
    $view->with('sidebar', array('10' => $sidebar));
});
