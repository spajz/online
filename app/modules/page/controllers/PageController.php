<?php namespace Page\Controllers;

use View;
use Config;
use Page\Models\Page;
use Front\Controllers\FrontController;


class PageController extends FrontController
{
    public function __construct()
    {
        $configModule = Config::get('page::module', array());

        foreach ($configModule as $key => $value) {
            $this->$key = $value;
        }

        View::share($configModule);
    }

    public function show($slug)
    {
        $model = $this->modelName;

        $item = $model::where('slug', $slug)->first();

        $vars['item'] = $item;

        $this->layout->content = View::make("{$this->moduleLower}::front.single", $vars);
    }

    public function gameShow($slug)
    {
        $model = $this->modelName;

        $vars['slug'] = $slug;
        $vars['title'] = ' - ' . ucfirst($slug) . ' Game';

        $this->layout->content = View::make("{$this->moduleLower}::front.game-single", $vars);
    }

    public function gameIndex()
    {
        $model = $this->modelName;

        $vars['item'] = '';

        $this->layout->content = View::make("{$this->moduleLower}::front.game-list", $vars);
    }

}