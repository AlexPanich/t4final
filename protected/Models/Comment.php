<?php

namespace App\Models;


use T4\Core\Exception;

class Comment extends BaseModel
{
    public static $schema = [
        'columns' => [
            'body' => ['type' => 'text'],
            'published_at' => ['type' => 'datetime'],
            '__user_id' => ['type' => 'link'],
            '__photo_id' => ['type' => 'link']
        ],
        'relations' => [
            'photo' => ['type' => self::BELONGS_TO, 'model' => Photo::class],
            'user' => ['type' => self::BELONGS_TO, 'model' => User::class]
        ],
    ];

    public static function create($attributes)
    {
        $attributes['published_at'] = date('Y-m-d H:i:s');
        return parent::create($attributes);
    }

    public function validateBody($val)
    {
        if (mb_strlen($val) <= 3) {
            throw new Exception('Слишком короткий комментарий');
        }
        return true;
    }

}