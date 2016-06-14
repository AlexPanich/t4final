<?php

namespace App\Models;


class User extends BaseModel
{
    static public $schema = [
        'table' => '__users',

        'columns' => [
            'email' => ['type' => 'string'],
            'password' => ['type' => 'string'],
            'firstName' => ['type' => 'string', 'length' => 50],
            'lastName' => ['type' => 'string', 'length' => 50],
        ],
        'relations' => [
            'comments' => ['type' => self::HAS_MANY, 'model' => Comment::class],
            'roles' => ['type' => self::MANY_TO_MANY, 'model' => Role::class]
        ]
    ];

    public function isAdmin()
    {
        return !$this->roles->isEmpty() && $this->roles->reduce(true, function($care, $role){
            return $care && $role->name == 'admin';
        });

    }

    public function afterDelete()
    {
        foreach ($this->comments as $comment) {
            $comment->delete();
        }

        //TODO удаление записей из таблицы связей с ролями
    }

    public function getRolesAsString()
    {
        $roles = $this->roles->map(function($role) {
            return $role->title;
        });

        return implode(', ', $roles->toArray());
    }
}