<?php

// Module enabled;
$json = Helper::getJsonFile(__DIR__ . '/module.json');

if ($json['enabled']) {

    extract(Config::get('catalog::module', array()));

    Route::group(array("prefix" => "admin", "before" => "admin"), function () use ($moduleUpper, $moduleLower) {

        Route::get($moduleLower, array("as" => "admin.{$moduleLower}.index", "uses" => $moduleUpper . '\Controllers\\' . "{$moduleUpper}Controller@index"));

        Route::get("{$moduleLower}/{id}/edit", array("as" => "admin.{$moduleLower}.edit", "uses" => $moduleUpper . '\Controllers\\' . "{$moduleUpper}Controller@edit"));

        Route::put("{$moduleLower}/{id}", array("as" => "admin.{$moduleLower}.update", "uses" => $moduleUpper . '\Controllers\\' . "{$moduleUpper}Controller@update"));

        Route::get("{$moduleLower}/image/{id}/destroy", array("as" => "admin.{$moduleLower}.image.destroy", "uses" => $moduleUpper . '\Controllers\\' . "{$moduleUpper}Controller@destroyImage"));

        Route::get("api/{$moduleLower}/dt", array("as" => "api.{$moduleLower}.dt", "uses" => $moduleUpper . '\Controllers\\' . "{$moduleUpper}Controller@getDatatable"));

    });

    // Menu
    $data = View::make("{$moduleLower}::admin.menu", array('moduleUpper' => $moduleUpper, 'moduleLower' => $moduleLower));
    Helper::Collector("menu", $data, $json['order']);

}

