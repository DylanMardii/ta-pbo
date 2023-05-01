<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Kategori extends BaseController
{
    protected $role = null;
    protected $kategoriModel;
    protected $produkModel;

    public function __construct()
    {
        if (!session()->has('user')) return redirect()->to('user/login');
        $this->role = session()->get('user')['role'];
        $this->kategoriModel = new \App\Models\KategoriModel();
        $this->produkModel = new \App\Models\ProdukModel();
    }

    public function postIndex()
    {
        helper('text');
        if ($this->role == null) return $this->unauthorized();
        if ($this->role != 'operator') return $this->forbidden();

        if (!$this->validate([
            'label' => 'required|min_length[1]',
        ])) {
            return $this->badRequest('Nama kategori wajib diisi.', 'kategori_message');
        }

        if ($this->request->getPost('idKategori') == '') {
            $id = 'kategori-' . time() . '-' . random_string('alnum', 10);
            $this->kategoriModel->insert([
                'id' => $id,
                'label' => $this->request->getPost('label'),
                'deskripsi' => $this->request->getPost('deskripsi'),
            ]);
            return $this->success('Kategori berhasil ditambahkan.', 'kategori_message');
        } else {
            $this->kategoriModel->save([
                'id' => $this->request->getPost('idKategori'),
                'label' => $this->request->getPost('label'),
                'deskripsi' => $this->request->getPost('deskripsi'),
            ]);
            return $this->success('Kategori berhasil diperbarui.', 'kategori_message');
        }
    }

    public function getDelete($id)
    {
        if ($this->role == null) return $this->unauthorized();
        if ($this->role != 'operator') return $this->forbidden();
        $kategori = $this->kategoriModel->where('id', $id)->first();
        if ($kategori == null) {
            return $this->notFound('Kategori tidak ditemukan');
        } else {
            if ($this->produkModel->where('kategori', $id)->countAllResults() > 0) {
                return $this->badRequest('Terdapat produk dengan kategori ini. Kategori tidak dapat dihapus.', 'kategori_message');
            }
            $this->kategoriModel->delete($id);
            return $this->success('Kategori berhasil dihapus.', 'kategori_message');
        }
    }

    public function getData($id)
    {
        if ($this->role == null) return $this->unauthorized();
        if ($this->role != 'operator') return $this->forbidden();
        $kategori = $this->kategoriModel->where('id', $id)->first();
        if ($kategori == null) {
            return $this->notFound('Kategori tidak ditemukan.');
        } else {
            return $this->success('Kategori berhasil ditemukan.', null, $kategori);
        }
    }
}
