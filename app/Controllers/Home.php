<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Home extends BaseController {
    protected $product;

    function __construct() {
        $this->product = new ProductModel();
    }
    public function index(): string {
        // Misalnya untuk mengambil semua data, bisa menggunakan fungsi findAll().
        $product = $this->product->findAll();
        // ditampung dalam variable array bernama $data
        $data['product'] = $product;

        // semua isi variable array $data diteruskan ke view v_home untuk ditampilkan
        return view('v_home', $data);
    }

    public function faq()
    {
        return view('v_faq');
    }

    public function profile()
    {
        return view('v_profile');
    }

    public function contact()
    {
        return view('v_contact');
    }
}