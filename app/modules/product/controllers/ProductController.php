<?php namespace Product\Controllers;

use Admin\Controllers\AdminController;
use Notification;
use View;
use Product\Models\Product;
use Product\Models\Attribute;
use Datatable;
use Former;
use Redirect;
use Input;
use DB;
use ImageApi;
use Config;
use ImageModel;
use HTML;

class ProductController extends AdminController
{
    public function __construct()
    {
        $configModule = Config::get('product::module', array());

        foreach ($configModule as $key => $value) {
            $this->$key = $value;
        }

        View::share($configModule);
    }

}