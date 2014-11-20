<?php

Route::filter('like', function () {
    if ($signed_request = parsePageSignedRequest()) {
        if (!$signed_request->page->liked) {
            return Redirect::to('holiday/like');
        }
    }
});

Route::filter('csrf2', function () {
    if (Session::token() != Input::get('_token')) {
        Notification::danger('Your security token is not valid. You have to start again.');
        return Redirect::route('holiday.photo');
    }
});

// Module enabled;
$json = Helper::getJsonFile(__DIR__ . '/module.json');

if ($json['enabled']) {

    extract(Config::get('holiday::module', array()));

    Route::group(array("prefix" => "admin", "before" => "admin"), function () use ($moduleUpper, $moduleLower) {

        Route::get($moduleLower, array("as" => "admin.{$moduleLower}.index", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@index"));

        Route::get("{$moduleLower}/{id}/edit", array("as" => "admin.{$moduleLower}.edit", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@edit"));

        Route::get("{$moduleLower}/{id}/destroy", array("as" => "admin.{$moduleLower}.destroy", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@destroy"));

        Route::get("{$moduleLower}/create", array("as" => "admin.{$moduleLower}.create", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@create"));

        Route::post($moduleLower, array("as" => "admin.{$moduleLower}.store", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@store"));

        Route::put("{$moduleLower}/{id}", array("as" => "admin.{$moduleLower}.update", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@update"));

        Route::get("{$moduleLower}/image/{id}/destroy", array("as" => "admin.{$moduleLower}.image.destroy", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@destroyImage"));

        Route::get("api/{$moduleLower}/dt", array("as" => "api.{$moduleLower}.dt", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@getDatatable"));

        Route::put("api/{$moduleLower}/image/preview", array("as" => "api.{$moduleLower}.image.preview", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@imagePreview"));

    });

    // Menu
    $data = View::make("{$moduleLower}::admin.menu", array('moduleUpper' => $moduleUpper, 'moduleLower' => $moduleLower));
    Helper::Collector("menu", $data, $json['order']);

    // Front routes

    Route::any("holiday/like", array("as" => "holiday.like", "uses" => $moduleUpper . '\Controllers\\' . "{$moduleUpper}Controller@index"));

    Route::group(array("prefix" => "holiday", "before" => "like"), function () use ($moduleUpper, $moduleLower) {

        //Route::any("/", array("as" => "holiday.index", "uses" => $moduleUpper . '\Controllers\\' . "{$moduleUpper}Controller@index"));

        Route::any("photo", array("as" => "holiday.photo", "uses" => $moduleUpper . '\Controllers\\' . "{$moduleUpper}Controller@photo"));

        Route::any("details", array("as" => "holiday.details", "uses" => $moduleUpper . '\Controllers\\' . "{$moduleUpper}Controller@details"));

        Route::any("finish", array("as" => "holiday.finish", "uses" => $moduleUpper . '\Controllers\\' . "{$moduleUpper}Controller@finish"));

        Route::post("photo/create", array("before" => "csrf2", "as" => "holiday.photo.create", "uses" => $moduleUpper . '\Controllers\\' . "{$moduleUpper}Controller@photoCreate"));

        Route::post("details/create", array("before" => "csrf2", "as" => "holiday.details.create", "uses" => $moduleUpper . '\Controllers\\' . "{$moduleUpper}Controller@detailsCreate"));

    });


}
