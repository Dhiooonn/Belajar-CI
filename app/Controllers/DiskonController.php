<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DiskonModel;

class DiskonController extends BaseController
{
    protected $diskonModel;

    public function __construct()
    {
        $this->diskonModel = new DiskonModel();
        // Logika untuk menyimpan diskon harian ke session
        $diskonModel = new DiskonModel();
        $tanggalHariIni = date('Y-m-d');

        $diskonHariIni = $diskonModel->where('tanggal', $tanggalHariIni)->first();
    
        // Jika ada diskon, simpan ke session
        if ($diskonHariIni) {
            session()->set('diskon_hari_ini', [
                'nominal' => $diskonHariIni['nominal'],
                'tanggal' => $diskonHariIni['tanggal']
            ]);
        } else {
            // Jika tidak ada diskon, pastikan sessionnya kosong
            session()->remove('diskon_hari_ini');
        }
    }

    public function index()
    {
        // Pengecekan role tidak perlu lagi di sini, karena sudah ditangani oleh filter di Routes
        $data = [
            'title'      => 'Manajemen Diskon',
            'diskon'     => $this->diskonModel->orderBy('tanggal', 'DESC')->findAll(),
            'validation' => \Config\Services::validation() // Kirim service validation ke view
        ];
        return view('v_diskon', $data);
    }

    public function store()
    {
        // Aturan validasi: tanggal wajib diisi dan harus unik di tabel 'diskon'
        $rules = [
            'tanggal' => [
                'rules' => 'required|is_unique[diskon.tanggal]',
                'errors' => [
                    'required' => 'Kolom tanggal wajib diisi.',
                    'is_unique' => 'Diskon untuk tanggal ini sudah ada. Silakan pilih tanggal lain.'
                ]
            ],
            'nominal' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Kolom nominal wajib diisi.',
                    'numeric' => 'Nominal harus berupa angka.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            // Jika validasi gagal, kembali ke halaman dengan pesan error
            return redirect()->to('/diskon')->withInput();
        }

        // Jika validasi berhasil, simpan data.
        // Tidak perlu set created_at/updated_at, karena model sudah useTimestamps = true
        $this->diskonModel->save([
            'tanggal' => $this->request->getPost('tanggal'),
            'nominal' => $this->request->getPost('nominal')
        ]);

        session()->setFlashdata('success', 'Data diskon berhasil ditambahkan.');
        return redirect()->to('/diskon');
    }

    // Fungsi ini diubah untuk mengembalikan JSON untuk kebutuhan AJAX modal edit
    public function edit($id)
    {
        $data = $this->diskonModel->find($id);
        if ($data) {
            return $this->response->setJSON($data);
        }
        return $this->response->setStatusCode(404, 'Data not found');
    }

    public function update($id)
    {
        // Validasi hanya untuk nominal, karena tanggal readonly
        $rules = [
            'nominal' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Kolom nominal wajib diisi.',
                    'numeric' => 'Nominal harus berupa angka.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/diskon')->withInput()->with('error', 'Gagal mengubah data. Periksa kembali inputan Anda.');
        }

        $this->diskonModel->update($id, [
            'nominal' => $this->request->getPost('nominal'),
        ]);

        session()->setFlashdata('success', 'Data diskon berhasil diperbarui.');
        return redirect()->to('/diskon');
    }

    public function delete($id)
    {
        $this->diskonModel->delete($id);
        session()->setFlashdata('success', 'Data diskon berhasil dihapus.');
        return redirect()->to('/diskon');
    }
}