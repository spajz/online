<?php namespace Online\Controllers;

use View;
use Config;
use Page\Models\Page;
use Front\Controllers\FrontController;
use Session;
use Redirect;
use Former;
use Input;


class OnlineController extends FrontController
{

    protected $contentPath;

    public function __construct()
    {
        $configModule = Config::get('online::module', array());

        foreach ($configModule as $key => $value) {
            $this->$key = $value;
        }

        $this->contentPath = Config::get('online::contentPath') . '/';

        View::share($configModule);
    }

    public function index()
    {
        $this->layout->content = View::make("{$this->moduleLower}::front.index");
    }

    public function show($slug)
    {
        $model = $this->modelName;

        $item = $model::where('slug', $slug)->first();

        if(!$item) return Redirect::route('home');

        $contentPath = $this->contentPath . $item->id;

        include_once($contentPath . '/functions.php');

        $formVars['route'] = route('online.process', $item->id);

        $vars['before'] = null;
        if(function_exists('_before')){
            $vars['before'] = _before();
        }

        if(!is_null(Session::get('_result'))){
            $formVars['result'] = Session::get('_result');
        }

        $vars['form'] =  View::make("{$this->moduleLower}::content.{$item->id}.form", $formVars);

        $vars['item'] = $item;

        $this->layout->content = View::make("{$this->moduleLower}::front.single", $vars);
    }

    public function process($id){

        $model = $this->modelName;

        $item = $model::where('id', $id)->first();
        if(!$item){
            return Redirect::route('home');
        }

        $contentPath = $this->contentPath . $item->id;

        include_once($contentPath . '/functions.php');

        $result = null;
        if(function_exists('_result')){
            $result = _result("{$this->moduleLower}::content.{$id}.result");
        }

        Session::flash('_result', $result);

        return Redirect::route('online.show', $item->slug)->withInput();

    }

    public function compose($view)
    {
        $view->with('count', User::count());
    }



}