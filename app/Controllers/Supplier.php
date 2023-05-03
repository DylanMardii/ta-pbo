<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Supplier extends BaseController
{
    protected $role = null;
    protected $invMasukModel;
    protected $supplierModel;

    public function __construct()
    {
        if (!session()->has('user')) return redirect()->to('user/login');
        $this->role = session()->get('user')['role'];
        $this->supplierModel = new \App\Models\SupplierModel();
        $this->invMasukModel = new \App\Models\InvMasukModel();
    }

    public function getIndex()
    {
        if ($this->role == null) return $this->unauthorized();
        if ($this->role != 'operator') return $this->forbidden();
        if ($this->request->getGet('q')) {
            $q = $this->request->getGet('q');
            $supplier = $this->supplierModel->select('id, nama')->like('nama', $q)->limit(10)->findAll();
            $this->response->setHeader('Content-Type', 'application/json');
            return json_encode([
                'status' => 'success',
                'message' => 'Supplier berhasil ditemukan.',
                'data' => $supplier
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
            return $this->badRequest('Nama supplier wajib diisi.', 'supplier_message');
        }

        if ($this->request->getPost('idSupplier') == '') {
            $id = 'supplier-' . time() . '-' . random_string('alnum', 10);
            $this->supplierModel->insert([
                'id' => $id,
                'nama' => $this->request->getPost('nama'),
                'alamat' => $this->request->getPost('alamat'),
                'telepon' => $this->request->getPost('telepon'),
                'email' => $this->request->getPost('email'),
            ]);
            return $this->success('Supplier berhasil ditambahkan.', 'supplier_message');
        } else {
            $this->supplierModel->save([
                'id' => $this->request->getPost('idSupplier'),
                'nama' => $this->request->getPost('nama'),
                'alamat' => $this->request->getPost('alamat'),
                'telepon' => $this->request->getPost('telepon'),
                'email' => $this->request->getPost('email'),
            ]);
            return $this->success('Supplier berhasil diperbarui.', 'supplier_message');
        }
    }

    public function getData($id)
    {
        if ($this->role == null) return $this->unauthorized();
        if ($this->role != 'manager') return $this->forbidden();
        $supplier = $this->supplierModel->where('id', $id)->first();
        if ($supplier == null) {
            return $this->notFound('Supplier tidak ditemukan.');
        } else {
            return $this->success('Supplier berhasil ditemukan.', null, $supplier);
        }
    }

    public function getDelete($id)
    {
        if ($this->role == null) return $this->unauthorized();
        if ($this->role != 'manager') return $this->forbidden();
        $kategori = $this->supplierModel->where('id', $id)->first();
        if ($kategori == null) {
            return $this->notFound('Kategori tidak ditemukan');
        } else {
            if ($this->invMasukModel->where('supplier', $id)->countAllResults() > 0) {
                return $this->badRequest('Terdapat invoice keluar dengan supplier ini. Supplier tidak dapat dihapus.', 'supplier_message');
            }
            $this->supplierModel->delete($id);
            return $this->success('Supplier berhasil dihapus.', 'supplier_message');
        }
    }
}
