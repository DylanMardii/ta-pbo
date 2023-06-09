<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    protected String $role = '';
    protected $roleModel;
    public function __construct()
    {
        if (session()->has('user')) $this->role = session()->get('user')['role'];
        $this->roleModel = new \App\Models\RoleModel();
    }

    public function getUsers()
    {
        if ($this->role != 'admin') return redirect()->to('user/login');
        $userModel = new \App\Models\UserModel();
        $q = $this->request->getGet('q') == null ? '' : $this->request->getGet('q');
        $data = [
            'title' => 'Dashboard ' . $this->roleModel->getRoleBySlug($this->role)['label'],
            'user' => session()->get('user'),
            'data' => [
                'users' => $userModel->like('username', $q)->orLike('name', $q)->select('user.*, role.label as role')->join('role', 'user.role = role.id', 'left')->paginate(5),
                'total' => $userModel->countAll(),
                'roles' => $this->roleModel->orderBy('label', 'asc')->findAll(),
                'q' => $q

            ],
            'pager' => $userModel->pager
        ];

        return view('dashboard/users', $data);
    }

    public function getIndex()
    {
        if ($this->role == '') return redirect()->to('user/login');
        $measurementModel = new \App\Models\MeasurementModel();
        $produkModel = new \App\Models\ProdukModel();
        $kategoriModel = new \App\Models\KategoriModel();
        $invKeluarModel = new \App\Models\InvKeluarModel();
        $invMasukModel = new \App\Models\InvMasukModel();
        $data = [
            'title' => 'Dashboard ' . $this->roleModel->getRoleBySlug($this->role)['label'],
            'user' => session()->get('user'),
            'data' => [
                'invoice_masuk' => $invKeluarModel->countAll(),
                'invoice_keluar' => $invMasukModel->countAll(),
                'produk' => $produkModel->countAll(),
                'satuan' => $measurementModel->countAll(),
                'kategori' => $kategoriModel->countAll(),
            ]
        ];
        return view('dashboard/index', $data);
    }

    public function getScanner()
    {
        if ($this->role != 'operator') return redirect()->to('user/login');
        $data = [
            'title' => 'Dashboard ' . $this->roleModel->getRoleBySlug($this->role)['label'],
            'user' => session()->get('user'),
        ];
        return view('dashboard/scanner', $data);
    }

    public function getIssuing()
    {
        if ($this->role != 'operator') return redirect()->to('user/login');
        $invKeluarModel = new \App\Models\InvKeluarModel();
        $q = $this->request->getGet('q') == null ? '' : $this->request->getGet('q');
        $klienModel = new \App\Models\KlienModel();
        $data = [
            'title' => 'Dashboard ' . $this->roleModel->getRoleBySlug($this->role)['label'],
            'user' => session()->get('user'),
            'data' => [
                'klien' => $klienModel->findAll(),
                'total' => $invKeluarModel->countAll(),
                'q' => $q,
                'invoices' => $invKeluarModel->select('inv_keluar.*, klien.nama as klien')->join('klien', 'inv_keluar.klien = klien.id')->like('referenceNumber', $q)->orLike('klien', $q)->orLike('deskripsi', $q)->orderBy('timestamp', 'DESC')->paginate(5),

            ],
            'pager' => $invKeluarModel->pager
        ];

        return view('dashboard/issuing', $data);
    }

    public function getReceiving()
    {
        if ($this->role != 'operator') return redirect()->to('user/login');
        $invMasuk = new \App\Models\InvMasukModel();
        $q = $this->request->getGet('q') == null ? '' : $this->request->getGet('q');
        $supplierModel = new \App\Models\SupplierModel();
        $data = [
            'title' => 'Dashboard ' . $this->roleModel->getRoleBySlug($this->role)['label'],
            'user' => session()->get('user'),
            'data' => [
                'total' => $invMasuk->countAll(),
                'supplier' => $supplierModel->findAll(),
                'q' => $q,
                'invoices' => $invMasuk->select('inv_masuk.*, supplier.nama as supplier')->like('referenceNumber', $q)->orLike('supplier', $q)->orLike('deskripsi', $q)->join('supplier', 'inv_masuk.supplier = supplier.id', 'left')->orderBy('timestamp', 'DESC')->paginate(5),
            ],
            'pager' => $invMasuk->pager
        ];
        return view('dashboard/receiving', $data);
    }

    public function getMeasurement()
    {
        if ($this->role != 'operator') return redirect()->to('user/login');
        $measurementModel = new \App\Models\MeasurementModel();
        $q = $this->request->getGet('q') == null ? '' : $this->request->getGet('q');
        $data = [
            'title' => 'Dashboard ' . $this->roleModel->getRoleBySlug($this->role)['label'],
            'user' => session()->get('user'),
            'data' => [
                'total' => $measurementModel->countAll(),
                'q' => $q,
                'measurement' => $measurementModel->like('label', $q)->orLike('deskripsi', $q)->orderBy('label')->paginate(5),
            ],
            'pager' => $measurementModel->pager
        ];
        return view('dashboard/measurement', $data);
    }

    public function getKategori()
    {
        if ($this->role != 'operator') return redirect()->to('user/login');
        $kategoriModel = new \App\Models\KategoriModel();
        $q = $this->request->getGet('q') == null ? '' : $this->request->getGet('q');
        $data = [
            'title' => 'Dashboard ' . $this->roleModel->getRoleBySlug($this->role)['label'],
            'user' => session()->get('user'),
            'data' => [
                'total' => $kategoriModel->countAll(),
                'q' => $q,
                'kategori' => $kategoriModel->like('label', $q)->orLike('deskripsi', $q)->orderBy('label')->paginate(5),
            ],
            'pager' => $kategoriModel->pager
        ];
        return view('dashboard/kategori', $data);
    }

    public function getProduk()
    {
        if ($this->role != 'operator') return redirect()->to('user/login');
        $kategoriModel = new \App\Models\KategoriModel();
        $satuanModel = new \App\Models\SatuanModel();
        $produkModel = new \App\Models\ProdukModel();
        $q = $this->request->getGet('q') == null ? '' : $this->request->getGet('q');
        $produk = $produkModel->select('produk.*, kategori.label as kategori, satuan.label as satuan')
            ->like('barcode', $q)->orLike('sku', $q)->orLike('nama', $q)->orLike('kategori.label', $q)
            ->join('kategori', 'kategori.id = produk.kategori', 'left')
            ->join('satuan', 'satuan.id = produk.satuan', 'left')
            ->orderBy('produk.nama', 'asc')->paginate(5);
        $data = [
            'title' => 'Dashboard ' . $this->roleModel->getRoleBySlug($this->role)['label'],
            'user' => session()->get('user'),
            'data' => [
                'kategori' => $kategoriModel->orderBy('label')->findAll(),
                'satuan' => $satuanModel->orderBy('label')->findAll(),
                'produk' => $produk,
                'total' => $produkModel->countAll(),
                'q' => $q,
            ],
            'pager' => $produkModel->pager
        ];
        return view('dashboard/produk', $data);
    }

    public function getKlien()
    {
        if ($this->role != 'manager') return redirect()->to('user/login');
        $klienModel = new \App\Models\KlienModel();
        $q = $this->request->getGet('q') == null ? '' : $this->request->getGet('q');
        $data = [
            'title' => 'Dashboard ' . $this->roleModel->getRoleBySlug($this->role)['label'],
            'user' => session()->get('user'),
            'data' => [
                'klien' => $klienModel->like('nama', $q)->orLike('alamat', $q)->orLike('telepon', $q)->orderBy('nama')->paginate(5),
                'total' => $klienModel->countAll(),
                'q' => $q,
            ],
            'pager' => $klienModel->pager,
        ];
        return view('dashboard/klien', $data);
    }

    public function getSupplier()
    {
        if ($this->role != 'manager') return redirect()->to('user/login');
        $supplierModel = new \App\Models\SupplierModel();
        $q = $this->request->getGet('q') == null ? '' : $this->request->getGet('q');
        $data = [
            'title' => 'Dashboard ' . $this->roleModel->getRoleBySlug($this->role)['label'],
            'user' => session()->get('user'),
            'data' => [
                'supplier' => $supplierModel->like('nama', $q)->orLike('alamat', $q)->orLike('telepon', $q)->orderBy('nama')->paginate(5),
                'total' => $supplierModel->countAll(),
                'q' => $q,
            ],
            'pager' => $supplierModel->pager,
        ];
        return view('dashboard/supplier', $data);
    }

    public function getLaporan()
    {
        if ($this->role != 'operator' && $this->role != 'manager') return redirect()->to('user/login');
        return redirect()->to('cetak/laporan');
    }
}
