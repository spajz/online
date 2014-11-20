<?php namespace Catalog\Controllers;

use Admin\Controllers\AdminController;
use Illuminate\Http\Request;
use Notification;
use View;
use Catalog\Models\Catalog;
use Datatable;
use Former;
use Redirect;
use Input;
use DB;
use ImageApi;
use Config;

class CatalogController extends AdminController
{
    public function __construct()
    {
        $configModule = Config::get('catalog::module', array());

        foreach ($configModule as $key => $value) {
            $this->$key = $value;
        }

        View::share($configModule);
    }

    public function index()
    {
        $vars['table'] = Datatable::table()
            ->addColumn('ID', 'Title', 'Status', 'Actions')
            ->setUrl(route("api.{$this->moduleLower}.dt"))
            ->noScript()
            ->setCallbacks(
                'aoColumnDefs', '[
                        {sClass:"center w40", aTargets:[2]},
                        {sClass:"center w170", aTargets:[3], bSortable: false }
                    ]'
            );

        $this->layout->content = View::make("{$this->moduleLower}::admin.index", $vars);
    }

    public function getDatatable()
    {
        $model = $this->modelName;
        $model = new $model;
        $modelNameSpace = get_class($model);
        $table = $model->getTable();
        $thisObj = $this;
        return Datatable::query(DB::table($table))
            ->showColumns('id', 'title', 'status')
//            ->searchColumns('title')
//            ->orderColumns('id', 'title', 'status')
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

        if (!$item) {
            Notification::danger('Item does not exist.');
            return Redirect::route("admin.{$this->moduleLower}.index");
        }

        Former::populate($item);

        $vars['item'] = $item;

        $this->layout->content = View::make("{$this->moduleLower}::admin.edit", $vars);
    }

    public function update($id)
    {
        $model = $this->modelName;
        $item = $model::find($id);

        $imageApi = new ImageApi();
        $imageApi->setModelId($id);
        $imageApi->setModelType(get_class($item));
        $imageApi->setConfig("{$this->moduleLower}::image");
        $imageApi->processUpload();

        if (empty($item)) {
            Notification::danger('Item does not exist.');
            return Redirect::route("admin.{$this->moduleLower}.index");
        }

        $item->update(Input::all());

        Notification::success('Item successfully updated.');

        return Redirect::route("admin.{$this->moduleLower}.edit", $id);

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