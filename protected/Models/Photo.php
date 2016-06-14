<?php

namespace App\Models;

use App\Components\Uploader;
use T4\Core\Exception;
use T4\Core\MultiException;

class Photo extends BaseModel
{
    public static $schema = [
        'columns' => [
            'title' => ['type' => 'string'],
            'description' => ['type' => 'text'],
            'path' => ['type' => 'string'],
            'published_at' => ['type' => 'datetime']
        ],
        'relations' => [
            'comments' => ['type' => self::HAS_MANY, 'model' => Comment::class]
        ]
    ];

    public static function create($attributes)
    {
        $uploader = new Uploader('file');
        if ($bool = ($uploader->isUploaded() && $uploader->checkExt())) {
            $res = $uploader->upload();
        }
        if ($res) {
            $attributes['path'] = $uploader->getPath();
            $attributes['published_at'] = date('Y-m-d H:i:s');
            try {
                parent::create($attributes);
            } catch (MultiException $e) {
                $uploader->fallback();
                throw $e;
            }
        } else {
            throw new Exception('Не удалась загрузка файла');
        }
    }

    public function validateTitle($val)
    {
        if ($val === '') {
            throw new Exception('Поле название должно быть заполненно');
        }
        if (mb_strlen($val) < 3) {
            throw new Exception('Слишком короткое название фотографии');
        }

        return true;
    }

    public function sanitizeTitle($val)
    {
        return mb_strtoupper(mb_substr($val, 0, 1)) . mb_strtolower(mb_substr($val, 1));
    }

    public function validateDescription($val)
    {
        if ($val === '') {
            throw new Exception('Поле описание должно быть заполненно');
        }
        if (mb_strlen($val) < 10) {
            throw new Exception('Слишком короткое описание фотографии');
        }

        return true;
    }

    public function getAbsPath()
    {
        return '/photos/' . $this->path;
    }

    public function getPreview()
    {
        if (mb_strlen($this->description) > 50) {
            return mb_substr($this->description, 0, 50) . '...';
        }
        return $this->description;
    }
}