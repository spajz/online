<?php namespace Holiday\Admin\Controllers;

use Admin\Controllers\AdminController;
use Illuminate\Http\Request;
use Notification;
use View;
use Holiday\Models\Holiday;
use Datatable;
use Former;
use Redirect;
use Input;
use DB;
use ImageApi;
use Config;
use File;
use Image;
use HTML;

class HolidayController extends AdminController
{
    protected $fbAlbumID = '269439793264770';

    public function __construct()
    {
        parent::__construct();

        $configModule = Config::get('holiday::module', array());

        foreach ($configModule as $key => $value) {
            $this->$key = $value;
        }

        View::share($configModule);
        View::share('changeStatusDisabled', true);
    }

    public function index()
    {
        $vars['table'] = Datatable::table()
            ->addColumn('ID', 'Image', 'Full Name', 'Status', 'Actions')
            ->setUrl(route("api.{$this->moduleLower}.dt"))
            ->noScript()
            ->setCallbacks(
                'aoColumnDefs', '[
                        {sClass:"center w40", aTargets:[0]},
                        {sClass:"center w40", aTargets:[3]},
                        {sClass:"center w170", aTargets:[4], bSortable: false }
                    ]'
            );

        $this->layout->content = View::make("{$this->moduleLower}::admin.index", $vars);
    }

    public function getDatatable()
    {
        $config = Config::get($this->moduleLower . '::config', array());

        $model = $this->modelName;
        $model = new $model;
        $modelNameSpace = get_class($model);
        $thisObj = $this;
        return Datatable::collection($model::where('stage', '>', 0)->orderBy('id', 'desc')->get())
            ->showColumns('id')
//            ->searchColumns('title')
//            ->orderColumns('id', 'title', 'status')

            ->addColumn('image', function ($data) use ($config) {
                if (isset($data->images[0])) {
                    $image = $data->images[0];
                    $out = '<a href="' . array_get($config, 'image.baseUrl') . 'large/' . $image->image . '" class="fancybox" rel="gallery">' .
                        HTML::image(Config::get("{$this->moduleLower}::image.baseUrl") . 'thumb/' . $image->image,
                            $image->alt,
                            array(
                                'class' => 'img-responsive col-centered',
                            )
                        ) .
                        '</a>';
                    return $out;
                }
            })

            ->showColumns('full_name')

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
        $vars['fonts'] = File::files(public_path() . '/fonts');

        $this->layout->content = View::make("{$this->moduleLower}::admin.edit", $vars);
    }

    public function update($id)
    {
        $model = $this->modelName;
        $item = $model::find($id);

        $post = Input::all();
        $save = Input::get('save');
        if (isset($save['reject'])) {
            Notification::success('Item rejected.');
            $item->status = -1;
            $item->save();
            return $this->redirect($item);
        }

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

        if (isset($save['publish'])) {
            $this->publish();
            Notification::success('Item successfully published.');
            $item->status = 1;
            $image = reset($post['image']);
            $item->photo = $image;
            $item->save();

            // Send photo to Facebook
            if ($this->facebookSession) {
                $parameters = array(
                    'source' => public_path('/media/images/holiday/' . $image)
                    //'message' => 'Lopata'
                );

                $this->facebookApi->fbPost("/{$this->fbAlbumID}/photos", $parameters);

                if ($this->facebookApi->getErrors()) {
                    Notification::danger($this->facebookApi->getErrors());
                }

            } else {
                Notification::danger('You must be logged in Facebook if you want to publish photos on Facebook.');
            }
        }

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

    public function imagePreview($publish = false)
    {
        $imgTmpDir = app_path() . '/tmp/img';
        $publishPath = public_path() . '/media/images/holiday';
        if (!File::isDirectory($imgTmpDir)) {
            File::makeDirectory($imgTmpDir);
        }
        clean_dir($imgTmpDir, 10);

        $post = Input::all();

        $basePath = Config::get("{$this->moduleLower}::image.path");
        $dirPath = $basePath . 'large/';

        $image = reset($post['image']);

        // Create a new image resource
        $img = Image::make($dirPath . $image);

        $angle = 0;
        $valign = 'bottom';
        $textPosition = Input::get('text_position');

        $text = Input::get('description');
        $fontSize = Input::get('text_size');
        $font = public_path() . '/fonts/' . Input::get('font');
        $textColor = Input::get('text_color');
        $bgColor = Input::get('bg_color');
        $bgColorRGB = hex2rgb($bgColor);
        $bgTransparency = Input::get('bg_transparency');
        $bgTransparencyDec = $bgTransparency / 100;

        if (Input::get('greyscale')) {
            $img->greyscale();
        }

        // Stamp
        $stamp = public_path() . '/packages/module/admin/assets/img/stamp.png';
        $stamp = Image::make($stamp);
        $stampCode = $stamp->getCore();

        // Set stamp opacity with helper function (intervention method not working)
        filter_opacity($stampCode, 40);
        $stamp->setCore($stampCode);
        $stamp->resize(null, $img->height(), function ($image) {
            $image->aspectRatio();
            $image->upsize();
        });

        if ($textPosition == 'top' || $textPosition == 'bottom') {

            $imageTextHorizontal = image_text_wrap($fontSize, $font, $text, $img->width());

            $boxHorizontal = imagettfbbox($fontSize, $angle, $font, $imageTextHorizontal);

            $msgHorizontal = Image::canvas($img->width() - 10, intval($boxHorizontal[1] + $fontSize * 3));

            $msgHorizontal->rectangle(0, 0, $msgHorizontal->width(), $msgHorizontal->height(), function ($draw) use ($bgColorRGB, $bgTransparencyDec) {
                $draw->background(array($bgColorRGB[0], $bgColorRGB[1], $bgColorRGB[2], $bgTransparencyDec));
            });

            $msgHorizontal->text($imageTextHorizontal, $fontSize, $fontSize * 2, function ($font) use ($post, $fontSize, $angle, $textColor, $valign) {
                $font->file(public_path() . '/fonts/' . $post['font']);
                $font->size($fontSize);
                $font->color($textColor);
            });

        } else {

            $imageTextVertical = image_text_wrap($fontSize, $font, $text, $img->height());

            $boxVertical = imagettfbbox($fontSize, $angle, $font, $imageTextVertical);

            $msgVertical = Image::canvas($img->height() - 10, intval($boxVertical[1] + $fontSize * 3));

            $msgVertical->rectangle(0, 0, $msgVertical->width(), $msgVertical->height(), function ($draw) use ($bgColorRGB, $bgTransparencyDec) {
                $draw->background(array($bgColorRGB[0], $bgColorRGB[1], $bgColorRGB[2], $bgTransparencyDec));
            });

            $msgVertical->text($imageTextVertical, $fontSize, $fontSize * 2, function ($font) use ($post, $fontSize, $angle, $textColor, $valign) {
                $font->file(public_path() . '/fonts/' . $post['font']);
                $font->size($fontSize);
                $font->color($textColor);
            });
        }

        switch ($textPosition) {
            case 'top':
                $img->insert($stamp, 'right');
                $img->insert($msgHorizontal, 'top', 0, 5);
                break;

            case 'bottom':
                $img->insert($stamp, 'right');
                $img->insert($msgHorizontal, 'bottom', 0, 5);
                break;

            case 'left':
                $img->insert($stamp, 'right');
                $msgVertical->rotate(90);
                $img->insert($msgVertical, 'left', 5, 5);
                break;

            case 'right':
                $stamp->flip('h');
                $img->insert($stamp, 'left');
                $msgVertical->rotate(-90);
                $img->insert($msgVertical, 'right', 5, 5);
                break;

        }

        if ($publish) {
            $path = $publishPath . '/' . $image;

            $img->save($path, 95);

            Notification::success('Image successfully saved.');

            return true;


        } else {
            $path = $imgTmpDir . '/' . Input::get('id') . '_' . uniqid() . '.jpg';

            $img->save($path, 95);

            echo urlencode2($path);
            exit;
        }


        // image_text_wrap($fontSize, $fontFace, $string, $width)
    }

    public function publish()
    {
        if ($this->imagePreview(true)) {
            // Publish to Facebook
        }
    }

    protected function sendToFacebook()
    {

//        try {
//
//            // Upload to a user's profile. The photo will be in the
//            // first album in the profile. You can also upload to
//            // a specific album by using /ALBUM_ID as the path
//            $response = (new FacebookRequest(
//                $session, 'POST', '/me/photos', array(
//                    'source' => new CURLFile('path/to/file.name', 'image/png'),
//                    'message' => 'User provided message'
//                )
//            ))->execute()->getGraphObject();
//
//            // If you're not using PHP 5.5 or later, change the file reference to:
//            // 'source' => '@/path/to/file.name'
//
//            echo "Posted with id: " . $response->getProperty('id');
//
//        } catch (FacebookRequestException $e) {
//
//            echo "Exception occured, code: " . $e->getCode();
//            echo " with message: " . $e->getMessage();
//
//        }

    }

    protected function redirect($item)
    {
        $save = Input::get('save');
        switch (true) {
            case isset($save['edit']):
                return Redirect::route("admin.{$this->moduleLower}.edit", $item->id);
                break;

            case isset($save['exit']):
                return Redirect::route("admin.{$this->moduleLower}.index");
                break;

            case isset($save['new']):
                return Redirect::route("admin.{$this->moduleLower}.create");
                break;

            case isset($save['reject']):
                return Redirect::route("admin.{$this->moduleLower}.edit", $item->id);
                break;

            case isset($save['publish']):
                return Redirect::route("admin.{$this->moduleLower}.edit", $item->id);
                break;
        }

        return Redirect::route("admin.{$this->moduleLower}.index");
    }
}