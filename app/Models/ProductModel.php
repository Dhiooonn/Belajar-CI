<?php
namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model {
    // Menyimoan nama teble
    protected $table = 'product';

    // Menyimpan field yang mejadi primary key
    protected $primaryKey = 'id';

    // Berisi daftar nama field yang diperbolehkan untuk dimanipulasi oleh project
    protected $allowedFields = [
        'nama', 'harga', 'jumlah', 'foto', 'created_at', 'updated_at'
    ];
}