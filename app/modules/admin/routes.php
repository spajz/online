<?php

$namespace = 'Admin\Controllers\\';

Route::filter('admin', function () {
    if (!Sentry::check()) {
        return Redirect::route('admin.login');
    }
});

Route::any("fb/back", array("as" => "fb.admin", "uses" => $namespace . "AdminController@fbBack"));

Route::any("fb/admin", array("as" => "fb.admin", "uses" => $namespace . "AdminController@fbAdmin"));

Route::any("fb/forget", array("as" => "fb.forget", "uses" => $namespace . "AdminController@fbForget"));

Route::any("fb/connect", array("as" => "fb.connect", "uses" => $namespace . "AdminController@fbConnect"));

Route::any("fb/logout", array("as" => "fb.logout", "uses" => $namespace . "AdminController@fbLogout"));

Route::any("ds", array("as" => "ds", "uses" => $namespace . "AdminController@destroySession"));

Route::any("dp", array("as" => "dp", "uses" => $namespace . "AdminController@destroyPermissions"));



Route::group(array('prefix' => 'admin', 'before' => 'admin'), function () use ($namespace) {

    Route::get('/', array('as' => 'admin', 'uses' => $namespace . 'AdminController@index'));

    Route::get('change-status', array('as' => 'admin.change.status', 'uses' => $namespace . 'AdminController@changeStatus'));

    Route::get('change-status', array('as' => 'admin.change.status', 'uses' => $namespace . 'AdminController@changeStatus'));

    Route::get("api/admin/get-image/{image}", array("as" => "api.admin.get.image", "uses" => $namespace . "AdminController@getImage"));

    Route::post("api/admin/get-dt-filter", array("as" => "api.admin.get.dt.filter", "uses" => $namespace . "AdminController@getDtFilter"));

});

Route::get('admin/login', array('as' => 'admin.login', 'uses' => $namespace . 'AdminController@login'));

Route::post('admin/login', array('before' => 'csrf', 'as' => 'admin.login', 'uses' => $namespace . 'AdminController@login'));

Route::get('sentry-user', array('as' => 'sentry.user', 'uses' => $namespace . 'AdminController@createSentryUser'));

Route::get('sentry-group', array('as' => 'sentry.group', 'uses' => $namespace . 'AdminController@createSentryGroup'));

Route::get('sentry-user-group', array('as' => 'sentry.user.group', 'uses' => $namespace . 'AdminController@sentryUserGroup'));

Route::get('sentry-login', array('as' => 'sentry.login', 'uses' => $namespace . 'AdminController@sentryLogin'));

Route::get('admin/logout', array('as' => 'admin.logout', 'uses' => $namespace . 'AdminController@logout'));

// Menu
$data = View::make('admin::menu');
Helper::Collector('menu', $data, 1);