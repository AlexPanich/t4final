<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1465897439_CreateCommentModel
    extends Migration
{

    public function up()
    {
        $this->createTable('comments', [
            'body' => ['type' => 'text'],
            'published_at' => ['type' => 'datetime'],
            '__user_id' => ['type' => 'link'],
            '__photo_id' => ['type' => 'link']
        ]);
    }

    public function down()
    {
        $this->dropTable('comments');
    }
    
}