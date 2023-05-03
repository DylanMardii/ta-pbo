<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Klien extends BaseController
{
    protected $role = null;
    protected $invKeluarModel;
    protected $klienModel;

    public function __construct()
    {
        if (!session()->has('user')) return redirect()->to('user/login');
        $this->role = session()->get('user')['role'];
        $this->klienModel = new \App\Models\KlienModel();
        $this->invKeluarModel = new \App\Models\InvKeluarModel();
    }

    public function getIndex()
    {
        if ($this->role == null) return $this->unauthorized();
        if ($this->role != 'operator') return $this->forbidden();
        if ($this->request->getGet('q')) {
            $q = $this->request->getGet('q');
            $klien = $this->klienModel->select('id, nama')->like('nama', $q)->limit(10)->findAll();
            $this->response->setHeader('Content-Type', 'application/json');
            return json_encode([
                'status' => 'success',
                'message' => 'Klien berhasil ditemukan.',
                'data' => $klien
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } else {
            return $this->badRequest('Silakan masukkan query');
        }
    }

    public function postIndex()
    {
        helper('text');
        if ($this->role == null) return $this->unauthorized();
        if ($this->role != 'manager') return $this->forbidden();

        if (!$this->validate([
            'nama' => 'required|min_length[1]',
        ])) {
            return $this->badRequest('Nama klien wajib diisi.', 'klien_message');
        }

        if ($this->request->getPost('idKlien') == '') {
            $id = 'klien-' . time() . '-' . random_string('alnum', 10);
            $this->klienModel->insert([
                'id' => $id,
                'nama' => $this->request->getPost('nama'),
                'alamat' => $this->request->getPost('alamat'),
                'telepon' => $this->request->getPost('telepon'),
                'email' => $this->request->getPost('email'),
            ]);
            return $this->success('Klien berhasil ditambahkan.', 'klien_message');
        } else {
            $this->klienModel->save([
                'id' => $this->request->getPost('idKlien'),
                'nama' => $this->request->getPost('nama'),
                'alamat' => $this->request->getPost('alamat'),
                'telepon' => $this->request->getPost('telepon'),
                'email' => $this->request->getPost('email'),
            ]);
            return $this->success('Klien berhasil diperbarui.', 'klien_message');
        }
    }

    public function getData($id)
    {
        if ($this->role == null) return $this->unauthorized();
        if ($this->role != 'manager') return $this->forbidden();
        $klien = $this->klienModel->where('id', $id)->first();
        if ($klien == null) {
            return $this->notFound('Klien tidak ditemukan.');
        } else {
            return $this->success('Klien berhasil ditemukan.', null, $klien);
        }
    }

    public function getDelete($id)
    {
        if ($this->role == null) return $this->unauthorized();
        if ($this->role != 'manager') return $this->forbidden();
        $kategori = $this->klienModel->where('id', $id)->first();
        if ($kategori == null) {
            return $this->notFound('Kategori tidak ditemukan');
        } else {
            if ($this->invKeluarModel->where('klien', $id)->countAllResults() > 0) {
                return $this->badRequest('Terdapat invoice keluar dengan klien ini. Klien tidak dapat dihapus.', 'klien_message');
            }
            $this->klienModel->delete($id);
            return $this->success('Klien berhasil dihapus.', 'klien_message');
        }
    }
}
