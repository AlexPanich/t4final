<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1465845058_CreatePhotoModel
    extends Migration
{

    public function up()
    {
        $this->createTable('photos', [
            'title' => ['type' => 'string'],
            'description' => ['type' => 'text'],
            'path' => ['type' => 'string'],
            'published_at' => ['type' => 'datetime']
        ]);
    }

    public function down()
    {
        $this->dropTable('photos');
    }
    
}