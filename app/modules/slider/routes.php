<?php

// Module enabled;
$json = Helper::getJsonFile(__DIR__ . '/module.json');

if ($json['enabled']) {

    extract(Config::get('slider::module', array()));

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
    Helper::Collector("menu", $data, $json['enabled']);

}

