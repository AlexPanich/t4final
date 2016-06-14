<?php

namespace App\Controllers;


use T4\Mvc\Controller;

class Photo extends Controller
{
    public function actionLast(int $num)
    {
        $this->data->photos = \App\Models\Photo::findAllByQuery('SELECT * FROM photos ORDER BY published_at DESC LIMIT ' . $num);
    }
}