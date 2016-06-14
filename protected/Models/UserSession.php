<?php

namespace App\Models;

use T4\Orm\Model;

class UserSession extends Model
{
    static public $schema = [
        'table' => '__users_sessions',

        'columns' => [
            'hash' => ['type' => 'string'],
        ],

        'relations' => [
            'user' => ['type' => self::BELONGS_TO, 'model' => User::class]
        ],
    ];
}