<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Produk extends BaseController
{
    protected $role = null;
    protected $produkModel;

    public function __construct()
    {
        if (!session()->has('user')) return redirect()->to('user/login');
        $this->role = session()->get('user')['role'];
        $this->produkModel = new \App\Models\ProdukModel();
    }

    public function getIndex()
    {
        if ($this->role == null) return $this->unauthorized();
        if ($this->role != 'operator') return $this->forbidden();
        if ($this->request->getGet('q')) {
            $q = $this->request->getGet('q');
            $produk = $this->produkModel->select('nama, barcode, sku, id')->like('nama', $q)->orLike('barcode', $q)->orLike('sku', $q)->paginate(10, 'produk');
            $this->response->setHeader('Content-Type', 'application/json');
            return json_encode([
                'status' => 'success',
                'message' => 'Produk berhasil ditemukan.',
                'data' => $produk
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } else {
            return $this->badRequest('Silakan masukkan query');
        }
    }

    public function getDetail($id)
    {
        if ($this->role == null) return $this->unauthorized();
        if ($this->role != 'operator') return $this->forbidden();
    }

    public function getData($id)
    {
        if ($this->role == null) return $this->unauthorized();
        if ($this->role != 'operator') return $this->forbidden();
        $produk = $this->produkModel->where('id', $id)->first();
        if ($produk == null) {
            return $this->notFound('Produk tidak ditemukan');
        } else {
            return $this->success('Produk berhasil ditemukan.', null, $produk);
        }
    }

    public function getDelete($id)
    {
        if ($this->role == null) return $this->unauthorized();
        if ($this->role != 'operator') return $this->forbidden();
        $produk = $this->produkModel->where('id', $id)->first();
        if ($produk == null) {
            return $this->notFound('Produk tidak ditemukan');
        } else {
            $this->response->setHeader('Content-Type', 'application/json');
            $this->produkModel->delete($id);
            return $this->success('Produk berhasil dihapus.', 'produk_message', $produk);
        }
    }

    public function postIndex()
    {
        helper('text');
        if ($this->role == null) return $this->unauthorized();
        if ($this->role != 'operator') return $this->forbidden();

        if ($this->request->getPost('id') == '') {
            $id = 'produk-' . time() . '-' . random_string('alnum', 10);
            $this->produkModel->insert([
                'id' => $id,
                'sku' => $this->request->getPost('sku'),
                'barcode' => $this->request->getPost('barcode'),
                'nama' => $this->request->getPost('nama'),
                'kategori' => $this->request->getPost('kategori'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'lokasi' => $this->request->getPost('lokasi'),
                'harga_beli' => $this->request->getPost('harga_beli'),
                'harga_jual' => $this->request->getPost('harga_jual'),
                'stok' => $this->request->getPost('stok'),
                'satuan' => $this->request->getPost('satuan'),
                'dimensi' => $this->request->getPost('dimensi'),
            ]);
            $this->response->setHeader('Content-Type', 'application/json');
            $this->success('Produk berhasil ditambahkan.', 'produk_message');
        } else {
            $this->produkModel->save([
                'id' => $this->request->getPost('id'),
                'sku' => $this->request->getPost('sku'),
                'barcode' => $this->request->getPost('barcode'),
                'nama' => $this->request->getPost('nama'),
                'kategori' => $this->request->getPost('kategori'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'lokasi' => $this->request->getPost('lokasi'),
                'harga_beli' => $this->request->getPost('harga_beli'),
                'harga_jual' => $this->request->getPost('harga_jual'),
                'stok' => $this->request->getPost('stok'),
                'satuan' => $this->request->getPost('satuan'),
                'dimensi' => $this->request->getPost('dimensi'),
            ]);
            return $this->success('Produk berhasil diperbarui.', 'produk_message');
        }
    }
}
