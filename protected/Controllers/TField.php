<?php

namespace App\Controllers;


trait TField
{
    public function saveField($e)
    {
        $_SESSION['errors'] = $e;
        $_SESSION['fields'] = $this->app->request->post;
    }

    public function fillField()
    {
        if (isset($_SESSION['errors'])) {
            $this->data->errors = $_SESSION['errors'];
            $this->data->fields = $_SESSION['fields'];
            unset($_SESSION['errors']);
            unset($_SESSION['fields']);
        }
    }
}