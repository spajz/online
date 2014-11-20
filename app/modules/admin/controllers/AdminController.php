<?php namespace Admin\Controllers;

use BaseController;
use Illuminate\Support\Facades\Input;
use Sentry;
use View;
use Redirect;
use Notification;
use Request;
use Validator;
use File;
use Helper;
use Session;
use Config;
use FacebookApi;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use CustomSerializer;

//use Facebook\FacebookRequest;
//use Facebook\GraphObject;
//use Facebook\FacebookRequestException;
//use Facebook\GraphUser;
//use Facebook\FacebookRedirectLoginHelper;
//use Facebook\FacebookSession;
//use LaravelFacebookRedirectLoginHelper;

use Facebook;

class AdminController extends BaseController
{
    protected $layout = 'admin::layouts.master';
    protected $moduleUpper;
    protected $moduleLower;
    protected $modelName;
    protected $facebookApi = null;
    protected $facebookSession = null;

    public function __construct()
    {
        $this->facebookApi = new FacebookApi('holiday');
        $this->facebookSession = $this->facebookApi->getSession();

        if ($this->facebookSession) {
            View::share('fbUserProfile', $this->facebookApi->getUser());
        } else {
            View::share('fbUserProfile', false);
        }
    }

    public function fbAdmin()
    {
        echo 'FB ADMIN';
        exit;
    }

    public function fbLogout()
    {
        $facebookApi = new FacebookApi('holiday');
        $logout = $facebookApi->processLogout();
        if ($logout) {
            return Redirect::away($logout);
        }

        Notification::danger('Your Facebook session has expired.');
        return Redirect::back();

    }

    public function fbConnect()
    {
        $facebookApi = new FacebookApi('holiday');
        $result = $facebookApi->authenticate();

        if ($result === TRUE) {
            //Redirect user to home. Login success
            return Redirect::route('admin');
        } else {
            //The $result is a string. Redirect to this URL
            return Redirect::away($result);
        }
    }

    public function fbBack()
    {
        $facebookApi = new FacebookApi('holiday');

        if ($facebookApi->handleCallback() === TRUE) {
            return Redirect::to('admin/holiday');
        } else {
            die('Facebook callback error.');
        }
    }


    public function destroySession()
    {
        Session::flush();
    }

    public function destroyPermissions()
    {
        $facebookApi = new FacebookApi('holiday');
        $facebookApi->destroyPermissions();
    }

    public function fbLogin()
    {
        echo 'FB LOGIN';
        exit;


    }

    public function index()
    {
        $modules = File::directories(app_path() . '/modules');

        $vars['modules'] = array();

        foreach ($modules as $dir) {
            $json = Helper::getJsonFile($dir . '/module.json');
            if ($json['enabled'] && $json['dashboard']) {
                $vars['modules'][$json['order']] = array(
                    'module' => basename($dir),
                    'icon' => $json['icon']
                );
            }
        }

        ksort($vars['modules']);

        $this->layout->content = View::make('admin::dashboard', $vars);
    }

    public function createSentryGroup()
    {
        try {
            // Create the group
            $group = Sentry::createGroup(array(
                'name' => 'Administrator',
                'permissions' => array(
                    'admin' => 1,
                    'users' => 1,
                ),
            ));
        } catch (\Cartalyst\Sentry\Groups\NameRequiredException $e) {
            echo 'Name field is required';
        } catch (\Cartalyst\Sentry\Groups\GroupExistsException $e) {
            echo 'Group already exists';
        }
    }

    public function createSentryUser()
    {

        try {
            // Create the user
            $user = Sentry::createUser(array(
                'email' => 'admin@admin.com',
                'password' => 'admin123',
                'activated' => true,
            ));

//            $user = Sentry::createUser(array(
//                'email' => 'admin@fcbafirma.rs',
//                'password' => 'fcb11000AFIRMA',
//                'activated' => true,
//            ));

            // Find the group using the group id
            $adminGroup = Sentry::findGroupById(1);

            // Assign the group to the user
            $user->addGroup($adminGroup);
        } catch (\Cartalyst\Sentry\Users\LoginRequiredException $e) {
            echo 'Login field is required.';
        } catch (\Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            echo 'Password field is required.';
        } catch (\Cartalyst\Sentry\Users\UserExistsException $e) {
            echo 'User with this login already exists.';
        } catch (\Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
            echo 'Group was not found.';
        }
    }

    public function sentryUserGroup()
    {
        try {
            // Find the user using the user id
            $user = Sentry::findUserById(1);

            // Find the group using the group id
            $adminGroup = Sentry::findGroupById(1);

            // Assign the group to the user
            if ($user->addGroup($adminGroup)) {
                // Group assigned successfully
                echo 'Group assigned successfully';
            } else {
                // Group was not assigned
                echo 'Group was not assigned';
            }
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            echo 'User was not found.';
        } catch (\Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
            echo 'Group was not found.';
        }
    }

    public function login()
    {
        $this->layout = null;

        if (Request::isMethod('post')) {

            $rules = array(
                'password' => 'required',
                'email' => 'required|email'
            );

            $validator = Validator::make(Input::all(), $rules);

            Input::flash();

            if ($validator->fails()) {

                $messages = $validator->messages();

                Notification::danger($messages->all());

                return Redirect::route('admin.login');
            }

            try {
                // Login credentials
                $credentials = array(
                    'email' => Input::get('email'),
                    'password' => Input::get('password'),
                );

                // Authenticate the user
                $user = Sentry::authenticate($credentials, false);
                return Redirect::route('admin');
            } catch (\Cartalyst\Sentry\Users\LoginRequiredException $e) {
                Notification::danger('Login field is required.');
            } catch (\Cartalyst\Sentry\Users\PasswordRequiredException $e) {
                Notification::danger('Password field is required.');
            } catch (\Cartalyst\Sentry\Users\WrongPasswordException $e) {
                Notification::danger('Wrong password, try again.');
            } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
                Notification::danger('User was not found.');
            } catch (\Cartalyst\Sentry\Users\UserNotActivatedException $e) {
                Notification::danger('User is not activated.');
            } // The following is only required if the throttling is enabled
            catch (\Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
                Notification::danger('User is suspended.');
            } catch (\Cartalyst\Sentry\Throttling\UserBannedException $e) {

            }

            return Redirect::route('admin.login');
        }

        return View::make('admin::login');
    }

    public function logout()
    {
        Sentry::logout();

        if (Sentry::check()) {
            Notification::danger('There is a error. You are still logged in.');
        } else {
            Notification::success('You have successfully logged out.');
        }
        return Redirect::route('admin.login');
    }

    public function changeStatus()
    {
        if (!Input::get('model')) return false;

        if (!Input::get('id')) return false;

        $model = urldecode2(Input::get('model'));

        $item = $model::find(Input::get('id'));

        if ($item->status != 1) $item->status = 1;
        else $item->status = 0;

        $item->save();

        return $this->dtStatusButton($item);
    }

    public function dtStatusButton($data, $model = null)
    {
        return View::make('admin::datatable.but_status', array('data' => $data, 'model' => $model));
    }

    public function getImage($path)
    {
        $path = urldecode2($path);
        header('Content-Type: image/jpeg');
        echo file_get_contents($path);
        exit;
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
        }

        return Redirect::route("admin.{$this->moduleLower}.index");
    }

    protected function redirectSubModule($item)
    {
        $save = Input::get('save');
        switch (true) {
            case isset($save['edit']):
                return Redirect::route("admin.{$this->moduleAdminRoute}.edit", $item->id);
                break;

            case isset($save['exit']):
                return Redirect::route("admin.{$this->moduleAdminRoute}.index");
                break;

            case isset($save['new']):
                return Redirect::route("admin.{$this->moduleAdminRoute}.create");
                break;
        }

        return Redirect::route("admin.{$this->moduleAdminRoute}.index");
    }
}