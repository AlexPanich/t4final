<?php

namespace App\Controllers;


use App\Models\Comment;
use App\Models\Photo;
use T4\Core\MultiException;
use T4\Mvc\Controller;

class Frontend extends Controller
{
    public function actionAllPhoto()
    {
        $this->data->photos = Photo::findAll();
    }

    public function actionShowPhoto($id)
    {
        if (isset($this->app->flash->errors)) {
            $this->data->errors = $this->app->flash->errors;
            $this->data->fields = $_SESSION['fields'];
        }

        $this->data->photo = Photo::findByPK($id);
    }

    public function actionStoreComment($id)
    {
        $attributes = $this->app->request->post;
        $attributes['__photo_id'] = $id;
        $attributes['__user_id'] = $this->app->user->pk;

        try {
            Comment::create($attributes);
        } catch (MultiException $e) {
            $this->app->flash->errors = $e;
            $_SESSION['fields'] = $this->app->request->post;
        }
        $this->redirect('/photo/'.$id);


    }
}