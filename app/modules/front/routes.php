<?php

// Module enabled;
$json = Helper::getJsonFile(__DIR__ . '/module.json');

if ($json['enabled']) {
    extract(Config::get('front::module', array()));
}