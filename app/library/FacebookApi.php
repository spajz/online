<?php

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\FacebookSDKException;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;

class FacebookApi
{
    protected $appName;
    protected $loginHelper;
    protected $facebookSession;
    protected $errors = array();
    protected $phpVersion = '5.5.0';

    public function __construct($appName)
    {
        $this->appName = $appName;
        $this->initFacebook();
        $this->tryGetSession();
    }

    private function initFacebook()
    {
        try {
            FacebookSession::setDefaultApplication(Config::get("facebook.applications.{$this->appName}.appId"), Config::get("facebook.applications.{$this->appName}.secret"));
            $this->loginHelper = new LaravelFacebookRedirectLoginHelper(Config::get("facebook.applications.{$this->appName}.redirectUrl"));
        } catch (FacebookSDKException $e) {
            dd($e->getMessage());
        }
    }

    public function handleCallback()
    {
        try {
            $this->facebookSession = $this->loginHelper->getSessionFromRedirect();
            Session::put('fb_token', $this->facebookSession->getToken());
            return true;
        } catch (FacebookRequestException $e) {
            dd($e->getMessage());
        }
    }

    public function authenticate($providedToken = null)
    {
        if ($providedToken !== null) {
            $this->tryValidateSession($providedToken);
        }

        if ($this->facebookSession == null) {
            echo Config::get("facebook.applications.{$this->appName}.redirectUrl");

            $url = $this->loginHelper->getLoginUrl(Config::get("facebook.applications.{$this->appName}.scopes"));

            return $url;
        } else {
            return true;
        }
    }

    public function getSession()
    {
        return $this->facebookSession;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    protected function setErrors($errors)
    {
        $this->errors = array_merge($this->errors, $errors);
    }

    public function getLogout()
    {
        if ($this->getSession()) {
            return $this->loginHelper->getLogoutUrl($this->facebookSession, url('admin'));
        }

        return false;
    }

    public function processLogout()
    {
        $logout = $this->getLogout();
        Session::forget('fb_token');
        Session::forget('state');
        return $logout;
    }

    public function getUser()
    {
        return $this->fbRequest('GET', '/me', array(), GraphUser::className());
    }

    public function fbRequest($method, $path, $parameters = array(), $type = 'Facebook\GraphObject')
    {
        if (in_array(strtoupper($method), array('POST'))){
            $parameters = $this->prepareParameters($parameters);
        }

        try {
            if ($this->getSession())
                return (new FacebookRequest($this->facebookSession, $method, $path, $parameters))->execute()->getGraphObject($type);

        } catch (FacebookRequestException $e) {
            $this->setErrors((array)$e->getMessage());
            return false;
        }

        return false;
    }

    public function fbGet($path, $parameters = array())
    {
        return $this->fbRequest('GET', $path, $parameters);
    }

    public function fbPost($path, $parameters = array())
    {
        return $this->fbRequest('POST', $path, $parameters);
    }

    public function fbDelete($path, $parameters = array())
    {
        return $this->fbRequest('DELETE', $path, $parameters);
    }

    public function fbDestroyPermissions(){
        return $this->fbRequest('DELETE', '/me/permissions');
    }

    protected function prepareParameters($parameters)
    {
        if (isset($parameters['source'])) {
            if (version_compare(phpversion(), $this->phpVersion, '<')) {
                $parameters['source'] = '@' . $parameters['source'];
            } else {
                $parameters['source'] = new CURLFile($parameters['source']);
            }
        }
        return $parameters;
    }

    private function tryGetSession()
    {
        if (Session::has('fb_token')) {
            $this->facebookSession = new FacebookSession(Session::get('fb_token'));

            try {
                if (!$this->facebookSession->validate()) {
                    $this->facebookSession = null;
                }
            } catch (Exception $e) {
                $this->facebookSession = null;
            }
        }
    }

    private function tryValidateSession($accessToken)
    {
        $this->facebookSession = new FacebookSession($accessToken);

        try {
            $this->facebookSession->validate();
        } catch (FacebookSDKException $e) {
            dd($e->getMessage());
        }
    }
}