<?php namespace Holiday\Controllers;

use Admin\Controllers\AdminController;
use Request;
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
use Session;
use Mail;

class HolidayController extends AdminController
{
    protected $layout = 'holiday::front.layouts.master';

    public function __construct()
    {
        parent::__construct();

        $configModule = Config::get('holiday::module', array());

        foreach ($configModule as $key => $value) {
            $this->$key = $value;
        }

        View::share($configModule);

    }

    public function index()
    {
        $vars = array();
        $this->layout->content = View::make("{$this->moduleLower}::front.index", $vars);
    }

    public function photo()
    {
        $vars = array();
        $this->layout->content = View::make("{$this->moduleLower}::front.photo", $vars);
    }

    public function photoCreate()
    {
        $model = $this->modelName;
        $item = new $model(Input::all());
        $item->hash_delete = sha1(time() . str_random(8));
        $item->hash_activate = sha1(str_random(8) . time());

        $imageApi = new ImageApi();
        $imageApi->setModelType(get_class($item));
        $imageApi->setConfig("{$this->moduleLower}::image");
        $imageApi->setBaseName('holiday');
        $imageApi->upload(true);
        $errors = $imageApi->getErrors();
        if (!empty($errors)) {
            Notification::danger($errors);
            return Redirect::route('holiday.photo');
        } else {
            $item->save();
            $imageApi->setModelId($item->id);
            $imageApi->processUpload();
        }

        Session::set('holiday', $item->id);
        return Redirect::route('holiday.details');

    }

    public function details()
    {
        $vars = array();
        $this->layout->content = View::make("{$this->moduleLower}::front.details", $vars);
    }

    public function detailsCreate()
    {
        $id = Session::get('holiday');
        $model = $this->modelName;

        if (!is_numeric($id)) {
            //Notification::danger('Your session has expired. You have to start again.');
            Notification::danger('Seksioni juaj ka përfunduar. Ju duhet të filloni përsëri.');
            return Redirect::route('holiday.photo');
        }

        $item = $model::find($id);

        if (!$item) {
            //Notification::danger('An error occurred on the server. Please try again.');
            Notification::danger('Një gabim ka ndodhur në server. Ju lutem provoni përsëri.');
            return Redirect::route('holiday.photo');
        }

        Session::forget('holiday');
        $item->update(Input::all());
        $item->stage = 1;
        $item->save();
        $item->ip = Request::getClientIp();

        $this->sendEmail(
            $item->email,
            "{$this->moduleLower}::front.email.user",
            'Konfirmim për pjesëmarrjen në Fushatën BKT "Nda një selfie, fito një çmim."',
            array('item' => $item)
        );

        $this->sendEmail(
            array('jona.saliaj@dfcbaja.al'),
            "{$this->moduleLower}::front.email.admin",
            "BKT Holiday - new photo [{$item->full_name}]",
            array('item' => $item)
        );

        return Redirect::route('holiday.finish');
    }

    public function finish()
    {
        $vars = array();
        $this->layout->content = View::make("{$this->moduleLower}::front.finish", $vars);
    }

    protected function sendEmail($to, $view, $subject, $data)
    {
        Mail::send($view, $data, function ($message) use ($to, $subject) {
            $message->to((array)$to);
            $message->from('no-reply@bkt.com.al', 'BKT Facebook');
            $message->to($to);
            $message->subject($subject);
        });
    }
}