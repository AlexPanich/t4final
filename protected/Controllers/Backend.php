<?php

namespace App\Controllers;

use App\Models\Photo;
use App\Models\User;
use T4\Core\Exception;
use T4\Core\MultiException;
use T4\Mvc\Controller;

class Backend extends Controller
{
    protected function access($action, $params = [])
    {
        return $this->app->user->isAdmin();
    }

    public function actionIndex()
    {

    }

    public function actionAllUsers()
    {
        $users = User::findAll();
        $this->data->users = $users;
    }

    public function actionDeleteUser()
    {

    }

    public function actionShowUser()
    {

    }

    public function actionAllPhoto()
    {
        $this->data->photos = Photo::findAll();

    }

    public function actionAddPhoto()
    {
        if (isset($this->app->flash->errors)) {
            $this->data->errors = $this->app->flash->errors;
            $this->data->fields = $_SESSION['fields'];
        }
    }

    public function actionStorePhoto()
    {
        if ($this->app->request->method != 'post') {
            $this->redirect('/admin');
        }
        try {
            Photo::create($this->app->request->post);
        } catch(MultiException $e) {
            $this->app->flash->errors = $e;
            $_SESSION['fields'] = $this->app->request->post;
            $this->redirect('/admin/photo/add');
        } catch(Exception $e) {
            $this->app->flash->errors = [$e];
            $_SESSION['fields'] = $this->app->request->post;
            $this->redirect('/admin/photo/add');
        }

        $this->redirect('/admin/photo');
    }

    public function actionEditPhoto()
    {

    }

    public function actionUpgradePhoto()
    {

    }

    public function actionDeletePhoto()
    {

    }

    public function actionDeleteComment()
    {

    }
}