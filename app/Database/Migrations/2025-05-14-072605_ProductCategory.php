<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProductCategory extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => TRUE,
            ],
            'created_at' => [
                'type' => 'Datetime',
                'null' => TRUE,
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => TRUE,
            ],
            'deleted_at' => [
                'type' => 'datetime',
                'null' => TRUE,
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('product_category');
    }

    public function down()
    {
        $this->forge->dropTable('product_category');
    }
}