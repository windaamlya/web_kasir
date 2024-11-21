<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PelangganModel;
use CodeIgniter\CLI\Console;
use CodeIgniter\HTTP\ResponseInterface;

class Pelanggan extends BaseController
{
    protected $pelangganmodel;

    public function __construct()
    {
        $this->pelangganmodel = new PelangganModel();
    }

    // Halaman utama pelanggan
    public function index()
    {
        return view('v_pelanggan');
    }

    // Menampilkan data pelanggan
    public function tampil_pelanggan()
    {
        try {
            $pelanggan = $this->pelangganmodel->findAll();  // Mendapatkan data pelanggan

            return $this->response->setJSON([
                'status'    => 'success',
                'pelanggan' => $pelanggan
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status'    => 'error',
                'message'   => 'Terjadi kesalahan saat mengambil data pelanggan: ' . $e->getMessage()
            ], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Menyimpan data pelanggan
    public function simpan_pelanggan()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama_pelanggan' => 'required',
            'alamat' => 'required',
            'no_tlp' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors(),
            ], ResponseInterface::HTTP_BAD_REQUEST);
        }

        $data = [
            'nama_pelanggan' => $this->request->getVar('nama_pelanggan'),
            'alamat'         => $this->request->getVar('alamat'),
            'no_tlp'         => $this->request->getVar('no_tlp'),
        ];

        try {
            $this->pelangganmodel->save($data);  // Simpan data ke dalam database

            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Data pelanggan berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data pelanggan: ' . $e->getMessage()
            ], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Menghapus data pelanggan
    public function delete($id)
    {
        try {
            // Pastikan ID pelanggan valid
            if ($this->pelangganmodel->find($id)) {
                $this->pelangganmodel->delete($id);  // Hapus data pelanggan

                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Pelanggan berhasil dihapus'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Pelanggan tidak ditemukan'
                ], ResponseInterface::HTTP_NOT_FOUND);  // HTTP 404
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus data pelanggan: ' . $e->getMessage()
            ], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);  // HTTP 500
        }
    }

    // Menampilkan data pelanggan untuk di-edit
    public function edit_pelanggan()
    {
        $id = $this->request->getVar('id');
        $model = new pelangganmodel();
        $data = $model->find($id);
        
        if ($data) {
            return $this->response->setJSON($data);  // Kirimkan data produk dalam format JSON
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Pelanggan tidak ditemukan'], 404);
        }
    }

    // Update data pelanggan
    public function update_pelanggan()
    {
        $id = $this->request->getVar('id_pelanggan');

        // Validasi input dari AJAX
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama_pelanggan' => 'required',
            'alamat' => 'required',
            'no_tlp' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors(),
            ]);
        }

        $data = [
            'nama_pelanggan' => $this->request->getVar('nama_pelanggan'),
            'alamat' => $this->request->getVar('alamat'),
            'no_tlp'        => $this->request->getVar('no_tlp'),
        ];

        // Update produk
        $this->pelangganmodel->update($id, $data);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Data produk berhasil diupdate',
        ]);

        
    }
}
