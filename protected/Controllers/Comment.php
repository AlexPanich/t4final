<?php

namespace App\Controllers;


use T4\Mvc\Controller;

class Comment extends Controller
{
    public function actionLast(int $num)
    {
        $this->data->comments = \App\Models\Comment::findAllByQuery('SELECT * FROM comments ORDER BY published_at DESC LIMIT ' . $num);
    }
}