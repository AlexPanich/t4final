<?php

namespace App\Components;


class Uploader
{
    protected $fieldName = '';
    protected $name;
    protected $ext;
    const ALLOW_EXT = ['jpg', 'jpeg', 'png'];

    public function __construct($fieldName)
    {
        $this->fieldName = $fieldName;
        $tmp = explode('.', $_FILES[$this->fieldName]['name']);
        $this->ext = end($tmp);
    }

    public function isUploaded()
    {
        return isset($_FILES[$this->fieldName]) && $_FILES[$this->fieldName]['error'] == 0;
    }

    public function checkExt()
    {
        return in_array($this->ext, self::ALLOW_EXT);
    }

    public function upload()
    {
        return move_uploaded_file($_FILES[$this->fieldName]['tmp_name'],
            ROOT_PATH_PUBLIC . '/photos/' . $this->getName());
    }

    public function getPath()
    {
        return $this->name;
    }

    public function fallback()
    {
        $filename = ROOT_PATH_PUBLIC . '/photos/' . $this->name;
        if (file_exists($filename)) {
            unlink($filename);
        }
    }

    private function getName()
    {
        if (is_null($this->name)) {
            do {
                $this->name = sha1(microtime() . mt_rand()) . '.' . $this->ext;
            } while (file_exists(ROOT_PATH_PUBLIC . '/photos/' . $this->name));
        }
        return $this->name;
    }
}