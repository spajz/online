<?php namespace Online\Admin\Controllers;

use Admin\Controllers\AdminController;
use Response;
use Notification;
use View;
use Online\Models\Online;
use Online\Models\Category;
use Datatable;
use Former;
use Redirect;
use Input;
use ImageApi;
use Config;
use ImageModel;
use HTML;
use File;

class OnlineController extends AdminController
{
    protected $contentPath;
    protected $files = array('form.blade.php', 'functions.php', 'result.blade.php');

    public function __construct()
    {
        parent::__construct();

        $configModule = Config::get('online::module', array());

        foreach ($configModule as $key => $value) {
            $this->$key = $value;
        }

        $this->contentPath = Config::get('online::contentPath') . '/';

        View::share($configModule);
        View::share('config', Config::get("online::config", array()));
    }

    public function index()
    {
        $vars['table'] = Datatable::table()
            ->addColumn('ID', 'Title', 'Group', 'Featured', 'Status', 'Actions')
            ->setUrl(route("api.{$this->moduleAdminRoute}.dt"))
            ->noScript()
            ->setId('table_' . $this->moduleLower)
            ->setCallbacks(
                'aoColumnDefs', '[
                        {sClass:"center w40", aTargets:[0]},
                        {sClass:"center w40", aTargets:[3]},
                        {sClass:"center w40", aTargets:[4]},
                        {sClass:"center w170", aTargets:[5], bSortable: false }
                    ]'
            );

        $categories = Category::orderBy('title')->lists('title');
        $this->setDtSelectFilter(2, $categories);

        $this->layout->content = View::make("{$this->moduleLower}::admin.index", $vars);
    }

    public function getTags()
    {
        $tags = array('Amesterdam', 'Beograd', 'London', 'Kula', 'Zemun', 'Moskva');

        return Response::json($tags);
    }

    public function getDatatable()
    {
        $config = Config::get($this->moduleLower . '::config', array());

        $model = $this->modelName;
        $model = new $model;
        $modelNameSpace = get_class($model);
        $thisObj = $this;
        return Datatable::collection($model::all())
            ->searchColumns(array('1' => 'title', '2' => 'category_id'))
            //->orderColumns('id', 'title', 'status')
            ->showColumns('id')
            ->showColumns('title')
            ->addColumn('category_id', function ($data) {
                return isset($data->category->title) ? $data->category->title : '';
            })
            ->addColumn('featured', function ($data) use ($thisObj, $modelNameSpace) {
                return $thisObj->dtStatusButton($data, $modelNameSpace, 'featured')->render();
            })
            ->addColumn('status', function ($data) use ($thisObj, $modelNameSpace) {
                return $thisObj->dtStatusButton($data, $modelNameSpace)->render();
            })
            ->addColumn('actions', function ($data) {
                return View::make("{$this->moduleLower}::admin.datatable.but_actions", array('data' => $data))->render();
            })
            ->make();
    }

    public function edit($id)
    {
        $model = $this->modelName;
        $item = $model::find($id);

        $categories = Category::allLeaves()->get();

        $categoriesArray = array();
        foreach ($categories as $k => $category) {
            $tmp = implode('/', array_reverse(array_flatten($category->getAncestors()->lists('title'))));
            if($tmp) $categoriesArray[$category->id] = $tmp . '/' . $category->title;
            else $categoriesArray[$category->id] = $category->title;
        }

        asort($categoriesArray, SORT_NATURAL | SORT_FLAG_CASE);
        $vars['categories'] = array('0' => '* N/A') + $categoriesArray;



//        $t = \Conner\Tagging\Tag::all();
//        dd($t);

        if (!$item) {
            Notification::danger('Item does not exist.');
            return Redirect::route("admin.{$this->moduleAdminRoute}.index");
        }

        // Check content
        $contentPath = $this->contentPath . $id;
        if (!is_dir($contentPath)) {
            mkdir($contentPath);
        }

        foreach ($this->files as $file) {
            if (!is_file($contentPath . '/' . $file)) {
                file_put_contents($contentPath . '/' . $file, '');
            }

            $vars['contentFiles'][$file] = file_get_contents($contentPath . '/' . $file);
        }

        Former::populate($item);

        $vars['item'] = $item;

        $this->layout->content = View::make("{$this->moduleLower}::admin.edit", $vars);
    }

    public function update($id)
    {
        $model = $this->modelName;
        $item = $model::find($id);
        $contentPath = $this->contentPath . $id;


        if (empty($item)) {
            Notification::danger('Item does not exist.');
            return Redirect::route("admin.{$this->moduleAdminRoute}.index");
        }

        // Add tags
        $tags = Input::get('tags');
        if (empty($tags)) $item->untag();
        else $item->retag(Input::get('tags'));

        foreach ($this->files as $file) {
            if (Input::get(base64_encode($file), false) !== false) {
                file_put_contents($contentPath . '/' . $file, Input::get(base64_encode($file)));
            }
        }

        $imageApi = new ImageApi();
        $imageApi->setModelId($id);
        $imageApi->setModelType(get_class($item));
        $imageApi->setConfig("{$this->moduleLower}::image");
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

        return $this->redirect($item);
    }

    public function create()
    {
        $model = $this->modelName;

        $this->layout->content = View::make("{$this->moduleLower}::admin.create");
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

        return $this->redirect($item);
    }

    public function destroy($id)
    {
        $model = $this->modelName;
        $item = $model::find($id);

        if (!$item) {
            Notification::danger('Item does not exist.');
        } else {
            $item->delete();

            // Delete content files
            File::deleteDirectory($this->contentPath . $id);

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