<?php

namespace App\Controllers;

use App\Components\Auth\Identity;
use App\Components\Auth\MultiException;
use T4\Mvc\Controller;

class Auth extends Controller
{
    public function actionLogin($login = null)
    {
        if ($login !== null) {

            try {
                $auth = new Identity();
                $auth->login($login);
                $this->redirect('/photo');
            } catch (MultiException $e) {
                $this->data->errors = $e;
            }
        }
    }

    public function actionLogout()
    {
        $auth = new Identity();
        $auth->logout();
        $this->redirect('/');
    }

    public function actionRegister()
    {
        if ($this->app->request->method == 'post') {
            try {
                $auth = new Identity();
                $auth->register($this->app->request->post);
                $this->redirect('/photo');
            } catch (MultiException $e) {
                $this->data->errors = $e;
            }
        }
    }
}