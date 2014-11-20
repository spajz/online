<?php

// Module enabled;
$json = Helper::getJsonFile(__DIR__ . '/module.json');

// Home page
Route::get('/', array("as" => "home", "uses" => 'Page\Controllers\HomeController@index'));

if ($json['enabled']) {

    extract(Config::get('page::module', array()));

    Route::group(array("prefix" => "admin", "before" => "admin"), function () use ($moduleUpper, $moduleLower) {

        Route::get($moduleLower, array("as" => "admin.{$moduleLower}.index", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@index"));

        Route::get("{$moduleLower}/{id}/edit", array("as" => "admin.{$moduleLower}.edit", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@edit"));

        Route::get("{$moduleLower}/{id}/destroy", array("as" => "admin.{$moduleLower}.destroy", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@destroy"));

        Route::get("{$moduleLower}/create", array("as" => "admin.{$moduleLower}.create", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@create"));

        Route::post($moduleLower, array("as" => "admin.{$moduleLower}.store", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@store"));

        Route::put("{$moduleLower}/{id}", array("as" => "admin.{$moduleLower}.update", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@update"));

        Route::get("{$moduleLower}/image/{id}/destroy", array("as" => "admin.{$moduleLower}.image.destroy", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@destroyImage"));

        Route::get("api/{$moduleLower}/dt", array("as" => "api.{$moduleLower}.dt", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@getDatatable"));

    });

    // Menu
    $data = View::make("{$moduleLower}::admin.menu", array('moduleUpper' => $moduleUpper, 'moduleLower' => $moduleLower));
    Helper::Collector("menu", $data, $json['order']);

    // Front routes
    Route::get("{$moduleLower}/{slug}", array("as" => "{$moduleLower}.show", "uses" => $moduleUpper . '\Controllers\\' . "{$moduleUpper}Controller@show"));

    Route::get("game", array("as" => "game.index", "uses" => $moduleUpper . '\Controllers\\' . "{$moduleUpper}Controller@gameIndex"));

    Route::get("game/{slug}", array("as" => "game.show", "uses" => $moduleUpper . '\Controllers\\' . "{$moduleUpper}Controller@gameShow"));

}

