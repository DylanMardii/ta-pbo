<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Issuing extends BaseController
{
    protected String $role = '';
    protected $roleModel;
    protected $invKeluarModel;
    public function __construct()
    {
        if (!session()->has('user')) return redirect()->to('user/login');
        $this->role = session()->get('user')['role'];
        $this->roleModel = new \App\Models\RoleModel();
        $this->invKeluarModel = new \App\Models\InvKeluarModel();
    }

    public function postIndex()
    {
        helper('text');
        if (!$this->validate([
            'referenceNumber' => 'required',
            'waktuMasuk' => 'required',
            'pajak' => 'required',
            'klien' => 'required',
        ])) {
            return $this->badRequest('Pastikan semua field terisi.', 'issuing_message');
        }

        if ($this->request->getPost('id') !== null) {
            $this->invKeluarModel->update($this->request->getPost('id'), [
                'referenceNumber' => $this->request->getPost('referenceNumber'),
                'deskripsi' => $this->request->getPost('status'),
                'timestamp' => $this->request->getPost('waktuMasuk'),
                'pajak' => $this->request->getPost('pajak'),
                'klien' => $this->request->getPost('klien'),
            ]);
            return $this->success('Invoice berhasil diperbarui.', 'issuing_message');
        } else {
            if (!$this->validate([
                'referenceNumber' => 'is_unique[inv_keluar.referenceNumber]',
            ])) {
                return $this->badRequest('Nomor referensi sudah terdaftar.', 'issuing_message');
            }
            $id = 'IM-' . time() . '-' . random_string('alnum', 10);
            $this->invKeluarModel->insert([
                'id' => $id,
                'referenceNumber' => $this->request->getPost('referenceNumber'),
                'deskripsi' => 'Open',
                'timestamp' => $this->request->getPost('waktuMasuk'),
                'pajak' => 10,
                'klien' => $this->request->getPost('klien'),
            ]);
            return $this->success('Invoice berhasil dibuat.', 'issuing_message');
        }
    }

    public function getDelete($id)
    {
        if ($this->role == null) return $this->unauthorized();
        if ($this->role != 'operator') return $this->forbidden();
        $invoice = $this->invKeluarModel->where('id', $id)->first();
        $penjualanModel = new \App\Models\PenjualanModel();
        if ($invoice == null) {
            return $this->notFound('Invoice tidak ditemukan');
        } else {
            $this->invKeluarModel->delete($id);
            $penjualanModel->where('idInvoice', $id)->delete();
            return $this->success('Invoice berhasil dihapus.', 'issuing_message', $invoice);
        }
    }

    public function postAddProduct()
    {
        helper('text');
        if ($this->role == null) return $this->unauthorized();
        if ($this->role != 'operator') return $this->forbidden();
        $id = $this->request->getPost('id');
        $productCode = $this->request->getPost('idProduct');
        $amount = (int) $this->request->getPost('amount');

        $invoice = $this->invKeluarModel->where('id', $id)->first();
        if ($invoice == null) {
            return $this->notFound('Invoice tidak ditemukan.', 'issuing_message');
        }

        $produkModel = new \App\Models\ProdukModel();
        $produk = $produkModel->where('id', $productCode)->orWhere('barcode', $productCode)->orWhere('sku', $productCode)->first();
        if ($produk == null) {
            return $this->notFound('Produk tidak ditemukan', 'issuing_message');
        }

        if ($amount <= 0) {
            return $this->badRequest('Jumlah produk tidak boleh kurang dari 1.', 'issuing_message');
        }

        if ($produk['stok'] < $amount) {
            return $this->badRequest('Stok produk kurang. Tersedia: ' . $produk['stok'], 'issuing_message');
        }

        $penjualanModel = new \App\Models\PenjualanModel();
        $item = $penjualanModel->where('idInvoice', $id)->where('idProduk', $produk['id'])->first();
        if ($item == null) {
            $penjualanModel->insert([
                'id' => 'JS-' . time() . '-' . random_string('alnum', 10),
                'idInvoice' => $id,
                'idProduk' => $produk['id'],
                'sku' => $produk['sku'],
                'barcode' => $produk['barcode'],
                'nama' => $produk['nama'],
                'kuantitas' => $amount,
                'harga' => $produk['harga_beli']
            ]);
        } else {
            $penjualanModel->where('id', $item['id'])->set('kuantitas', $item['kuantitas'] + $amount, true)->update();
        }
        $produkModel->where('id', $produk['id'])->set('stok', $produk['stok'] - $amount, true)->update();

        return $this->success('Produk berhasil ditambahkan.', 'issuing_message', $invoice);
    }

    public function postDeleteProduct()
    {
        helper('text');
        if ($this->role == null) return $this->unauthorized();
        if ($this->role != 'operator') return $this->forbidden();
        $id = $this->request->getPost('id');

        $penjualanModel = new \App\Models\PenjualanModel();
        $produkModel = new \App\Models\ProdukModel();
        $item = $penjualanModel->where('id', $id)->first();

        if ($item == null) {
            return $this->notFound('Entri tidak ditemukan.');
        }

        $produk = $produkModel->where('id', $item['idProduk'])->first();
        if ($produk == null) {
            $penjualanModel->delete($item['id']);
            return $this->success('Item berhasil dihapus.', 'issuing_message');
        }

        $penjualanModel->delete($item['id']);
        $produkModel->set('stok', $produk['stok'] + $item['kuantitas'], true)->where('id', $item['idProduk'])->update();
        return $this->success('Item berhasil dihapus.', 'issuing_message');
    }

    public function getForm($id = '')
    {
        $invoiceData = null;
        $penjualanModel = new \App\Models\PenjualanModel();
        if ($id != '') {
            $invoiceData = $this->invKeluarModel->where('id', $id)->first();
            if ($invoiceData == null) {
                session()->setFlashdata('issuing_message', [
                    'status' => 'error',
                    'message' => 'Invoice tidak ditemukan.'
                ]);
                return redirect()->to('/dashboard/issuing');
            }
        } else {
            return redirect()->to('/dashboard/issuing');
        }

        $klienModel = new \App\Models\KlienModel();
        $data = [
            'title' => 'Dashboard ' . $this->roleModel->getRoleBySlug($this->role)['label'],
            'user' => session()->get('user'),
            'data' => [
                'klien' => $klienModel->findAll(),
                'invoice' => $invoiceData,
                'items' => $penjualanModel->where('idInvoice', $id)->findAll()
            ]
        ];
        return view('issuing/form', $data);
    }
}
