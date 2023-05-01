<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Measurement extends BaseController
{
    protected $role = null;
    protected $measurementModel;
    protected $produkModel;

    public function __construct()
    {
        if (!session()->has('user')) return redirect()->to('user/login');
        $this->role = session()->get('user')['role'];
        $this->measurementModel = new \App\Models\MeasurementModel();
        $this->produkModel = new \App\Models\ProdukModel();
    }

    public function postIndex()
    {
        helper('text');
        if ($this->role == null) return $this->unauthorized();
        if ($this->role != 'operator') return $this->forbidden();

        if ($this->request->getPost('id') == '') {
            $id = 'satuan-' . time() . '-' . random_string('alnum', 10);
            $this->measurementModel->insert([
                'id' => $id,
                'label' => $this->request->getPost('label'),
                'deskripsi' => $this->request->getPost('deskripsi'),
            ]);
            return $this->success('Satuan berhasil ditambahkan.', 'measurement_message');
        } else {
            $this->measurementModel->save([
                'id' => $this->request->getPost('id'),
                'label' => $this->request->getPost('label'),
                'deskripsi' => $this->request->getPost('deskripsi'),
            ]);
            return $this->success('Satuan berhasil diperbarui.', 'measurement_message');
        }
    }

    public function getDelete($id)
    {
        if ($this->role == null) return $this->unauthorized();
        if ($this->role != 'operator') return $this->forbidden();
        $measurement = $this->measurementModel->where('id', $id)->first();
        if ($measurement == null) {
            return $this->notFound('Satuan tidak ditemukan');
        } else {
            if ($this->produkModel->where('satuan', $id)->countAllResults() > 0) {
                return $this->badRequest('Terdapat produk dengan satuan ini. Satuan tidak dapat dihapus.', 'measurement_message');
            }
            $this->measurementModel->delete($id);
            return $this->success('Satuan berhasil dihapus.', 'measurement_message', $measurement);
        }
    }

    public function getData($id)
    {
        if ($this->role == null) return $this->unauthorized();
        if ($this->role != 'operator') return $this->forbidden();
        $measurement = $this->measurementModel->where('id', $id)->first();
        if ($measurement == null) {
            return $this->notFound('Satuan tidak ditemukan');
        } else {
            return $this->success('Satuan berhasil ditemukan.', null, $measurement);
        }
    }
}
