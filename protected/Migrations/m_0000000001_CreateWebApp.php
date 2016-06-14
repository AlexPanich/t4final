<?php
namespace App\Migrations;

use T4\Orm\Migration;

class m_0000000001_CreateWebApp
    extends Migration
{
    public function up()
    {
        $this->createTable('__users', [
            'email' => ['type' => 'string'],
            'password' => ['type' => 'string'],
            'firstName' => ['type' => 'string', 'length' => 50],
            'lastName' => ['type' => 'string', 'length' => 50],
        ], [
            'email_idx' => ['type' => 'unique', 'columns' => ['email']],
        ]);

        $this->createTable('__user_roles', [
            'name' => ['type' => 'string'],
            'title' => ['type' => 'string'],
        ], [
            ['type' => 'unique', 'columns' => ['name']],
        ]);

        $this->createTable('__user_roles_to_users', [
            '__user_id' => ['type' => 'link'],
            '__role_id' => ['type' => 'link'],
        ]);

        $adminRoleId = $this->insert('__user_roles', [
            'name' => 'admin',
            'title' => 'Администратор',
        ]);

        $adminId = $this->insert('__users', [
            'email' => 'admin@admin.ru',
            'password' => '$2y$10$WrHaP8ZfbNrIOl75xIEWauS/txKCMe1x6dAbyhhcU2bTrpUZTKZLe',
        ]);

        $this->insert('__user_roles_to___users', [
            '__user_id' => $adminId,
            '__role_id' => $adminRoleId,
        ]);

        $this->createTable('__users_sessions', [
            'hash' => ['type' => 'string'],
            '__user_id' => ['type' => 'link']
        ], [
            'hash' => ['columns' => ['hash']],
            'user' => ['columns' => ['__user_id']]
        ]);
    }
    public function down()
    {
        $this->dropTable('__users_sessions');
        $this->dropTable('__user_role_to_users');
        $this->dropTable('__user_roles');
        $this->dropTable('__users');
    }
}