<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        // Menggunakan Library Fakerphp
        $faker = \Faker\Factory::create('id_ID');
     
        $data = [];
        
        for ($i = 0; $i < 10; $i++) {
            $data[] = [
            'name'          => $faker->words(2, true),
            'description'   => $faker->sentence(),
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
            'deleted_at'    => null,
            ];
        }

        $this->db->table('product_category') -> insertBatch($data);
    }
}