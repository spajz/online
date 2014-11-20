<?php namespace Product\Admin\Controllers;

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
        parent::__construct();

        $configModule = Config::get('product::module', array());

        foreach ($configModule as $key => $value) {
            $this->$key = $value;
        }

        View::share($configModule);
    }

    public function index()
    {
        $vars['table'] = Datatable::table()
            ->addColumn('ID', 'Image', 'Category', 'Title', 'Status', 'Actions')
            ->setUrl(route("api.{$this->moduleLower}.dt"))
            ->noScript()
            ->setCallbacks(
                'aoColumnDefs', '[
                        {sClass:"center w40", aTargets:[0]},
                        {sClass:"center mw120", aTargets:[1]},
                        {sClass:"center w40", aTargets:[4]},
                        {sClass:"center w170", aTargets:[5], bSortable: false }
                    ]'
            );

        $this->layout->content = View::make("{$this->moduleLower}::admin.index", $vars);
    }

    public function getDatatable()
    {
        $config = Config::get($this->moduleLower . '::config', array());
        $allCategories = $config['all_sub_categories'];
        $allCategories = $allCategories();

        $model = $this->modelName;
        $model = new $model;
        $modelNameSpace = get_class($model);
        $table = $model->getTable();
        $thisObj = $this;
        //return Datatable::query(DB::table($table))
        return Datatable::collection($model::all())
            ->showColumns('id')
            ->searchColumns('title')
            //->orderColumns('id', 'title', 'status')
            ->addColumn('image', function ($data) use ($config) {
                if (isset($data->attribute[0]) && isset($data->attribute[0]->images[0])) {
                    $image = $data->attribute[0]->images[0];
                    $out =  '<a href="' . array_get($config, 'image.baseUrl') . 'large/' . $image->image . '" class="fancybox" rel="gal-images">' .
                    HTML::image(Config::get("{$this->moduleLower}::image.baseUrl") . 'thumb/' . $image->image,
                        $image->alt,
                        array(
                            'class' => 'img-responsive col-centered',
                        )
                    ) .
                    '</a>';

                    foreach($data->attribute as $attribute){
                        $out .= '<i class="fa fa-square" style="color: ' . $attribute->hex_color . '"></i>&nbsp;';
                    }

                    return $out;
                }
            })
            ->addColumn('category', function ($data) use ($allCategories) {
                if (isset($allCategories[$data->category_id])) {
                    return $allCategories[$data->category_id];
                }
            })
            ->showColumns('title')
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

        // Images
        if (Input::get('images')) {
            foreach (Input::get('images') as $imageId => $data) {
                $image = ImageModel::find($imageId);
                if ($image) {
                    $image->update($data);
                }
            }
        }

        // Insert attributes
        if (Input::get('attributes.type')) {
            foreach (Input::get('attributes.type') as $key => $data) {
                $attribute = new Attribute(array(
                    'type' => Input::get('attributes.type.' . $key),
                    'value' => Input::get('attributes.value.' . $key),
                ));
                $item->attribute()->save($attribute);

                $imageApi = new ImageApi();
                $imageApi->setKey($key);
                $imageApi->setInputField('files', 'attributeImages.files.' . $key);
                $imageApi->setInputField('alt', 'attributeImages.alt');
                $imageApi->setModelId($attribute->id);
                $imageApi->setModelType(get_class($attribute));
                $imageApi->setConfig("{$this->moduleLower}::image");
                $imageApi->processUpload();
            }
        }

        // Update attributes
        if (Input::get('_attributes')) {
            foreach (Input::get('_attributes') as $key => $data) {
                $attribute = Attribute::find($key);
                if ($attribute) {
                    $attribute->update($data);
                }
            }
        }

        $item->update(Input::all());

        Notification::success('Item successfully updated.');

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
            Notification::success('Item successfully deleted.');
        }

        return Redirect::route("admin.{$this->moduleLower}.index");
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

    public function destroyAttribute($id)
    {
        $attribute = Attribute::find($id);
        if ($attribute) {
            if ($attribute->images()) {
                $imageApi = new ImageApi();
                $imageApi->setConfig("{$this->moduleLower}::image");
                $images = $attribute->images()->lists('id');
                if ($imageApi->destroy($images)) {
                    Notification::success('Image successfully deleted.');
                } else {
                    Notification::warning('An error occurred. Please try again.');
                }
            }

            if ($attribute->delete()) {
                Notification::success('Attribute successfully deleted.');
            } else {
                Notification::warning('An error occurred. Please try again.');
            }
        }
        return Redirect::back();
    }
}