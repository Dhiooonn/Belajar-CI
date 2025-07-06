<?php

namespace App\Models;
use CodeIgniter\Model;

class DiskonModel extends Model
{
    // Nama tabel di database Anda adalah 'diskon', ini sudah sesuai
    protected $table = 'diskon'; 
    
    // Pastikan primary key di tabel Anda adalah 'id'
    protected $primaryKey = 'id'; 
    
    protected $allowedFields = ['tanggal', 'nominal'];
    
    // Ini sudah benar, akan otomatis mengisi created_at & updated_at
    protected $useTimestamps = true; 
}