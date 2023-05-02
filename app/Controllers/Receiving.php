<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Receiving extends BaseController
{
    protected String $role = '';
    protected $roleModel;
    protected $invMasukModel;
    public function __construct()
    {
        if (!session()->has('user')) return redirect()->to('user/login');
        $this->role = session()->get('user')['role'];
        $this->roleModel = new \App\Models\RoleModel();
        $this->invMasukModel = new \App\Models\InvMasukModel();
    }

    public function postIndex()
    {
        helper('text');
        if ($this->request->getPost('id') !== null) {
            $this->invMasukModel->update($this->request->getPost('id'), [
                'referenceNumber' => $this->request->getPost('referenceNumber'),
                'deskripsi' => $this->request->getPost('status'),
                'timestamp' => $this->request->getPost('waktuMasuk'),
                'supplier' => $this->request->getPost('supplier'),
            ]);
            return $this->success('Invoice berhasil diperbarui.', 'receiving_message');
        } else {
            $id = 'IM-' . time() . '-' . random_string('alnum', 10);
            $this->invMasukModel->insert([
                'id' => $id,
                'referenceNumber' => $this->request->getPost('referenceNumber'),
                'deskripsi' => 'Open',
                'timestamp' => $this->request->getPost('waktuMasuk'),
                'supplier' => $this->request->getPost('supplier'),
            ]);
            return $this->success('Invoice berhasil dibuat.', 'receiving_message');
        }
    }

    public function getDelete($id)
    {
        if ($this->role == null) return $this->unauthorized();
        if ($this->role != 'operator') return $this->forbidden();
        $invoice = $this->invMasukModel->where('id', $id)->first();
        $penyetokanModel = new \App\Models\PenyetokanModel();
        if ($invoice == null) {
            return $this->notFound('Invoice tidak ditemukan');
        } else {
            $this->invMasukModel->delete($id);
            $penyetokanModel->where('idInvoice', $id)->delete();
            return $this->success('Invoice berhasil dihapus.', 'receiving_message', $invoice);
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

        $invoice = $this->invMasukModel->where('id', $id)->first();
        if ($invoice == null) {
            return $this->notFound('Invoice tidak ditemukan.', 'receiving_message');
        }

        $produkModel = new \App\Models\ProdukModel();
        $produk = $produkModel->where('id', $productCode)->orWhere('barcode', $productCode)->orWhere('sku', $productCode)->first();
        if ($produk == null) {
            return $this->notFound('Produk tidak ditemukan', 'receiving_message');
        }

        if ($amount <= 0) {
            return $this->badRequest('Jumlah produk tidak boleh kurang dari 1.', 'receiving_message');
        }

        $penyetokanModel = new \App\Models\PenyetokanModel();
        $item = $penyetokanModel->where('idInvoice', $id)->where('idProduk', $produk['id'])->first();
        if ($item == null) {
            $penyetokanModel->insert([
                'id' => 'MS-' . time() . '-' . random_string('alnum', 10),
                'idInvoice' => $id,
                'idProduk' => $produk['id'],
                'sku' => $produk['sku'],
                'barcode' => $produk['barcode'],
                'nama' => $produk['nama'],
                'kuantitas' => $amount,
                'harga' => $produk['harga_beli']
            ]);
        } else {
            $penyetokanModel->where('id', $item['id'])->set('kuantitas', $item['kuantitas'] + $amount, true)->update();
        }
        $produkModel->where('id', $produk['id'])->set('stok', $produk['stok'] + $amount, true)->update();

        return $this->success('Produk berhasil ditambahkan.', 'receiving_message', $invoice);
    }

    public function postDeleteProduct()
    {
        helper('text');
        if ($this->role == null) return $this->unauthorized();
        if ($this->role != 'operator') return $this->forbidden();
        $id = $this->request->getPost('id');

        $penyetokanModel = new \App\Models\PenyetokanModel();
        $produkModel = new \App\Models\ProdukModel();
        $item = $penyetokanModel->where('id', $id)->first();

        if ($item == null) {
            return $this->notFound('Entri tidak ditemukan.');
        }

        $produk = $produkModel->where('id', $item['idProduk'])->first();
        if ($produk == null) {
            $penyetokanModel->delete($item['id']);
            return $this->success('Item berhasil dihapus.', 'receiving_message');
        }

        if ($produk['stok'] < $item['kuantitas']) {
            return $this->badRequest('Stok produk kurang.', 'receiving_message');
        }

        $penyetokanModel->delete($item['id']);
        $produkModel->set('stok', $produk['stok'] - $item['kuantitas'], true)->where('id', $item['idProduk'])->update();
        return $this->success('Item berhasil dihapus.', 'receiving_message');
    }

    public function getForm($id = '')
    {
        $invoiceData = null;
        $penyetokanModel = new \App\Models\PenyetokanModel();
        if ($id != '') {
            $invoiceData = $this->invMasukModel->where('id', $id)->first();
            if ($invoiceData == null) {
                session()->setFlashdata('receiving_message', [
                    'status' => 'error',
                    'message' => 'Invoice tidak ditemukan.'
                ]);
                return redirect()->to('/dashboard/receiving');
            }
        } else {
            return redirect()->to('/dashboard/receiving');
        }

        $data = [
            'title' => 'Dashboard ' . $this->roleModel->getRoleBySlug($this->role)['label'],
            'user' => session()->get('user'),
            'data' => [
                'invoice' => $invoiceData,
                'items' => $penyetokanModel->where('idInvoice', $id)->findAll()
            ]
        ];
        return view('receiving/form', $data);
    }
}
