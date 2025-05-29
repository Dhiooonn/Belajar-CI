<?php

namespace App\Controllers;

use App\Models\ProductModel;

class ProdukController extends BaseController {
    protected $product;

    function __construct() {
        $this->product = new ProductModel();
    }

    public function index() {
        $product = $this->product->findAll();
        $data['product'] = $product;

        return view('v_produk', $data);
    }

    public function create(){
    $data = [
        'nama'   => $this->request->getPost('nama'),
        'harga'  => $this->request->getPost('harga'),
        'jumlah' => $this->request->getPost('jumlah'),
        'foto'   => ''
    ];

        // Upload file jika ada
        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('img', $newName);
            $data['foto'] = $newName;
        }

        if ($this->product->insert($data)) {
            return redirect()->to('/produk')->with('success', 'Data berhasil ditambahkan');
        } else {
            return redirect()->to('/produk')->with('failed', 'Data gagal ditambahkan');
        }
    }
}