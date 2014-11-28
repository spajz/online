<?php namespace Online\Admin\Controllers;

use Admin\Controllers\AdminController;
use Notification;
use View;
use Online\Models\Category;
use Datatable;
use Former;
use Redirect;
use Input;
use ImageApi;
use Config;
use ImageModel;
use HTML;
use Response;
use Online\Transformers\CategoryTransformer;
use Online\Transformers\CategoryTreeTransformer;
use FractalCustomSerializer;

use Fractal;

class CategoryController extends AdminController
{
    protected $mainModule;

    protected $sortNum = 1;

    public function __construct()
    {
        parent::__construct();

        $configModule = Config::get('online::category.module', array());
        $this->mainModule = Config::get('online::category.mainModule', array());
        $this->contentPath = Config::get('online::contentPath') . '/';

        foreach ($configModule as $key => $value) {
            $this->$key = $value;
        }

        View::share('mainModule', $this->mainModule);
        View::share($configModule);
        View::share('config', Config::get("online::category", array()));
    }

    public function index()
    {
        $vars['table'] = Datatable::table()
            ->addColumn('ID', 'Title', 'Parent', 'Parents', 'Status', 'Actions')
            ->setUrl(route("api.{$this->moduleAdminRoute}.dt"))
            ->noScript()
            ->setCallbacks(
                'aoColumnDefs', '[
                        {sClass:"center w40", aTargets:[0]},
                        {sClass:"center w40", aTargets:[4]},
                        {sClass:"center w170", aTargets:[5], bSortable: false }
                    ]'
            );

        $this->layout->content = View::make("{$this->mainModule}::admin.{$this->moduleLower}.index", $vars);
    }

    public function getDatatable()
    {
        $config = Config::get("{$this->mainModule}::{$this->moduleLower}", array());

        $model = $this->modelName;
        $model = new $model;
        $modelNameSpace = get_class($model);
        $thisObj = $this;
        return Datatable::collection($model::all())
            ->showColumns('id')
            ->searchColumns('title')
            //->orderColumns('id', 'title', 'status')

            ->showColumns('title')

            ->addColumn('parent', function ($data) {
                return $data->getParent('title');
            })

            ->addColumn('parents', function ($data) {
                return implode(', ', array_reverse(array_flatten($data->getAncestors()->lists('title'))));
            })

            ->addColumn('status', function ($data) use ($thisObj, $modelNameSpace) {
                return $thisObj->dtStatusButton($data, $modelNameSpace)->render();
            })
            ->addColumn('actions', function ($data) {
                return View::make("{$this->mainModule}::admin.{$this->moduleLower}.datatable.but_actions", array('data' => $data))->render();
            })
            ->make();
    }

    public function getTree()
    {
        $model = $this->modelName;
        $fractal = new Fractal();
        $fractal->setSerializer(new FractalCustomSerializer);
        //$fractal->parseIncludes('children');
        return $fractal->collection($model::orderBy('sort')->get()->toHierarchy(), new CategoryTransformer)->response();
    }

    private function addSortIndex(&$item, $key)
    {
        if ($key == 'sort') {
            $item = $this->sortNum++;
        }
    }

    public function postTree()
    {
        $model = $this->modelName;
        $fractal = new Fractal();
        $fractal->setSerializer(new FractalCustomSerializer);
        // $fractal->parseIncludes('children');

        $array = Input::get('children');

        array_walk_recursive($array, array($this, 'addSortIndex'));

        Category::buildTree($fractal->collection($array, new CategoryTreeTransformer)->getData()->toArray());
        print_r($fractal->collection($array, new CategoryTreeTransformer)->getData()->toArray());
        exit;
    }

    public function order()
    {
        $this->layout->content = View::make("{$this->mainModule}::admin.{$this->moduleLower}.order");
    }

    public function edit($id)
    {
        $model = $this->modelName;
        $item = $model::find($id);

        if (!$item) {
            Notification::danger('Item does not exist.');
            return Redirect::route("admin.{$this->moduleAdminRoute}.index");
        }

        Former::populate($item);

        $vars['item'] = $item;

        $this->layout->content = View::make("{$this->mainModule}::admin.{$this->moduleLower}.edit", $vars);
    }

    public function update($id)
    {
        $model = $this->modelName;
        $item = $model::find($id);

        if (empty($item)) {
            Notification::danger('Item does not exist.');
            return Redirect::route("admin.{$this->moduleAdminRoute}.index");
        }

        $imageApi = new ImageApi();
        $imageApi->setModelId($id);
        $imageApi->setModelType(get_class($item));
        $imageApi->setConfig("{$this->mainModule}::{$this->moduleLower}.image");
        $imageApi->processUpload();

        // Images
        if (Input::get('images')) {
            foreach (Input::get('images') as $imageId => $data) {
                $image = ImageModel::find($imageId);
                if ($image) {
                    $image->update($data);
                }
            }
        }

        $item->update(Input::all());

        return $this->redirectSubModule($item);
    }

    public function create()
    {
        $this->layout->content = View::make("{$this->mainModule}::admin.{$this->moduleLower}.create");
    }

    public function store()
    {
        $model = $this->modelName;
        $item = new $model(Input::all());
        $item->save();

        if ($item) {
            Notification::success('Item successfully created.');
        } else {
            Notification::warning('An error occurred. Please try again.');
            return Redirect::back();
        }

        return $this->redirectSubModule($item);
    }

    public function destroy($id)
    {
        $model = $this->modelName;
        $item = $model::find($id);

        if (!$item) {
            Notification::danger('Item does not exist.');
        } else {
            $item->delete();
            Notification::success('Item successfully deleted.');
        }

        return Redirect::route("admin.{$this->moduleAdminRoute}.index");
    }

    public function destroyImage($id)
    {
        $imageApi = new ImageApi();
        $imageApi->setConfig("{$this->moduleLower}::image");
        if ($imageApi->destroy($id)) {
            Notification::success('Image successfully deleted.');
        } else {
            Notification::warning('An error occurred. Please try again.');
        }

        return Redirect::back();

    }
}