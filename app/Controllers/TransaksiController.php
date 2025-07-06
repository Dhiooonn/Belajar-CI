<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class TransaksiController extends BaseController
{
        protected $cart;
        protected $client; // menyimpan objek dari client guzzle
        protected $apikey; //  API KEY
        protected $transaction; // Transaksi
        protected $transaction_detail ; // Detail Transaksi

    function __construct()
    {
        // Helper number digunakan untuk format harga barang (Rupiah).
        helper('number'); 
        helper('form');
        $this->cart = \Config\Services::cart();
        $this->client = new \GuzzleHttp\Client();
        $this->apikey = env('COST_KEY');
        $this->transaction = new TransactionModel();
        $this->transaction_detail = new TransactionDetailModel();
        // dd($this->apikey);
    }

    // Function index akan menampilkan isi data keranjang, dengan menggunakan fungsi contents bawaan dari modul.
    public function index()
    {
        $data['items'] = $this->cart->contents();
        $data['total'] = $this->cart->total();
        return view('v_keranjang', $data);
    }

    // Function cart_add() digunakan untuk menambahkan data produk ke keranjang, dengan menggunakan fungsi insert bawaan dari modul.
    public function cart_add()
    {
        $this->cart->insert(array(
            'id'        => $this->request->getPost('id'),
            'qty'       => 1,
            'price'     => $this->request->getPost('harga'),
            'name'      => $this->request->getPost('nama'),
            'options'   => array('foto' => $this->request->getPost('foto'))
        ));
        session()->setflashdata('success', 'Produk berhasil ditambahkan ke keranjang. (<a href="' . base_url() . 'keranjang">Lihat</a>)');
        return redirect()->to(base_url('/'));
    }

    // Function cart_clear() digunakan untuk mengosongkan keranjang
    public function cart_clear()
    {
        $this->cart->destroy();
        session()->setflashdata('success', 'Keranjang Berhasil Dikosongkan');
        return redirect()->to(base_url('keranjang'));
    }

    // Function cart_edit() digunakan untuk mengubah jumlah data produk di keranjang
    public function cart_edit()
    {
        $i = 1;
        foreach ($this->cart->contents() as $value) {
            $this->cart->update(array(
                'rowid' => $value['rowid'],
                'qty'   => $this->request->getPost('qty' . $i++)
            ));
        }

        session()->setflashdata('success', 'Keranjang Berhasil Diedit');
        return redirect()->to(base_url('keranjang'));
    }

    // Function cart_delete() digunakan untuk menghapus data produk dari keranjang
    public function cart_delete($rowid)
    {
        $this->cart->remove($rowid);
        session()->setflashdata('success', 'Keranjang Berhasil Dihapus');
        return redirect()->to(base_url('keranjang'));
    }

    // function checkout
    public function checkout() {
        $data['items'] = $this->cart->contents();
        $data['total'] = $this->cart->total();

        return view('v_checkout', $data);
    }

    // Function getLocatio 
    public function getLocation()
    {
            //keyword pencarian yang dikirimkan dari halaman checkout
        $search = $this->request->getGet('search');

        $response = $this->client->request(
            'GET', 
            'https://rajaongkir.komerce.id/api/v1/destination/domestic-destination?search='.$search.'&limit=50', [
                'headers' => [
                    'accept' => 'application/json',
                    'key' => $this->apikey,
                ],
            ]
        );

        $body = json_decode($response->getBody(), true); 
        return $this->response->setJSON($body['data']);
    }

    public function getCost()
    { 
            //ID lokasi yang dikirimkan dari halaman checkout
        $destination = $this->request->getGet('destination');

            //parameter daerah asal pengiriman, berat produk, dan kurir dibuat statis
        //valuenya => 64999 : PEDURUNGAN TENGAH , 1000 gram, dan JNE
        $response = $this->client->request(
            'POST', 
            'https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
                'multipart' => [
                    [
                        'name' => 'origin',
                        'contents' => '64999'
                    ],
                    [
                        'name' => 'destination',
                        'contents' => $destination
                    ],
                    [
                        'name' => 'weight',
                        'contents' => '1000'
                    ],
                    [
                        'name' => 'courier',
                        'contents' => 'jne'
                    ]
                ],
                'headers' => [
                    'accept' => 'application/json',
                    'key' => $this->apikey,
                ],
            ]
        );

        $body = json_decode($response->getBody(), true); 
        return $this->response->setJSON($body['data']);
    }
    
    // Function buy()
    public function buy()
    {
        if ($this->request->getPost()) {

            $diskon_per_item = session()->get('diskon_nominal') ?? 0;

            $total = 0;
            $total_diskon = 0;

            foreach ($this->cart->contents() as $value) {
                $subtotal = $value['price'] * $value['qty'];
                $diskon = $diskon_per_item * $value['qty'];

                $total += $subtotal;
                $total_diskon += $diskon;
            }

            $dataForm = [
                'username'    => $this->request->getPost('username'),
                'total_harga' => $total - $total_diskon,
                'alamat'      => $this->request->getPost('alamat'),
                'ongkir'      => $this->request->getPost('ongkir'),
                'status'      => 0,
                'created_at'  => date("Y-m-d H:i:s"),
                'updated_at'  => date("Y-m-d H:i:s")
            ];

            $this->transaction->insert($dataForm);
            $last_insert_id = $this->transaction->getInsertID();

            foreach ($this->cart->contents() as $value) {
                $qty = $value['qty'];
                $harga = $value['price'];
                $diskon_total_item = $diskon_per_item * $qty;

                $dataFormDetail = [
                    'transaction_id' => $last_insert_id,
                    'product_id'     => $value['id'],
                    'jumlah'         => $qty,
                    'diskon'         => $diskon_total_item,
                    'subtotal_harga' => ($harga * $qty) - $diskon_total_item,
                    'created_at'     => date("Y-m-d H:i:s"),
                    'updated_at'     => date("Y-m-d H:i:s")
                ];

                $this->transaction_detail->insert($dataFormDetail);
            }

            $this->cart->destroy();
            return redirect()->to(base_url());
        }
    }
}