<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DiskonSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('diskon');
        $now = new \DateTime();

        for ($i = 0; $i < 10; $i++) {
            $date = clone $now;
            $date->modify("+$i days");

            $builder->insert([
                'tanggal'    => $date->format('Y-m-d'),
                'nominal'    => rand(50000, 150000),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}