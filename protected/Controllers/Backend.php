<?php

namespace App\Controllers;

use App\Models\Comment;
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

    public function actionAllUser()
    {
        $users = User::findAll();
        $this->data->users = $users;
    }

    public function actionDeleteUser($id)
    {
        $user = User::findByPK($id);
        $user->delete();
        $this->redirect('/admin/user');
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

    public function actionEditPhoto($id)
    {
        if (isset($this->app->flash->errors)) {
            $this->data->errors = $this->app->flash->errors;
            $this->data->fields = $_SESSION['fields'];
        }
        $this->data->photo = Photo::findByPK($id);
    }

    public function actionUpdatePhoto($id)
    {
        if ($this->app->request->method != 'post') {
            $this->redirect('/admin');
        }

        try {
            $photo = Photo::findByPK($id);
            $photo->update($this->app->request->post);
            $this->redirect('/admin/photo');
        } catch (MultiException $e) {
            $this->app->flash->errors = $e;
            $_SESSION['fields'] = $this->app->request->post;
            $this->redirect('/admin/photo/edit/' . $id);
        } catch(Exception $e) {
            $this->app->flash->errors = [$e];
            $_SESSION['fields'] = $this->app->request->post;
            $this->redirect('/admin/photo/edit/' . $id);
        }
    }

    public function actionDeletePhoto($id)
    {
        $photo = Photo::findByPK($id);
        $photo->delete();
        $this->redirect('/admin/photo');
    }

    public function actionAllComment()
    {
        $this->data->comments = Comment::findAll();
    }

    public function actionDeleteComment($id)
    {
        $comment = Comment::findByPK($id);
        $comment->delete();
        $this->redirect('/admin/comment');
    }
}