<?php

namespace App\Models;


use T4\Orm\Model;

abstract class BaseModel extends Model
{
    public static function create($attributes)
    {
        return (new static)->fill($attributes)->save();
    }

    public function update($attributes)
    {
        return $this->fill($attributes)->save();
    }
}