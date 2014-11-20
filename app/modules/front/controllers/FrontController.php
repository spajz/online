<?php namespace Front\Controllers;

use BaseController;
use View;
use Config;

class FrontController extends BaseController
{
    protected $layout = 'front::layouts.master';
    protected $moduleUpper;
    protected $moduleLower;
    protected $modelName;

    public function __construct()
    {
        $configModule = Config::get('front::module', array());

        foreach ($configModule as $key => $value) {
            $this->$key = $value;
        }

        View::share($configModule);
    }

}