<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username', 'email', 'passowrd', 'role', 'created_at', 'ipdated_at'
    ];
}