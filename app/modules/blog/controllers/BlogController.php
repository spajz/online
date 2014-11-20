<?php namespace Blog\Controllers;

use View;
use Config;
use Blog\Models\Blog;
use Product\Models\Product;
use Front\Controllers\FrontController;
use DB;
use Redirect;


class BlogController extends FrontController
{
    public function __construct()
    {
        $configModule = Config::get('blog::module', array());

        foreach ($configModule as $key => $value) {
            $this->$key = $value;
        }

        View::share($configModule);
    }

    public function index()
    {
        $model = $this->modelName;

        $item = $model::select('*')->first();

        if($item){
            return Redirect::route('blog.show', $item->slug);
        }

        $vars['items'] = $model::all();

        $this->layout->content = View::make("{$this->moduleLower}::front.list", $vars);
    }

    public function show($slug)
    {
        $model = $this->modelName;

        $products = Product::orderBy(DB::raw('RAND()'))->take(9)->get();

        $vars['products'] = $products;

        $item = $model::where('slug', $slug)->first();

        $vars['item'] = $item;

        $vars['items'] = $model::all();

        $this->layout->content = View::make("{$this->moduleLower}::front.single", $vars);
    }

}