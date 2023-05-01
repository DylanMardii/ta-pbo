<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    protected String $role = '';
    protected $roleModel;
    public function __construct()
    {
        if (!session()->has('user')) return redirect()->to('user/login');
        $this->role = session()->get('user')['role'];
        $this->roleModel = new \App\Models\RoleModel();
    }

    public function getUsers()
    {
        $userModel = new \App\Models\UserModel();
        $q = $this->request->getGet('q') == null ? '' : $this->request->getGet('q');
        $data = [
            'title' => 'Dashboard ' . $this->roleModel->getRoleBySlug($this->role)['label'],
            'user' => session()->get('user'),
            'data' => [
                'users' => $userModel->select('user.*, role.label as role')->join('role', 'user.role = role.id', 'left')->paginate(5),
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
        $measurementModel = new \App\Models\MeasurementModel();
        $produkModel = new \App\Models\ProdukModel();
        $kategoriModel = new \App\Models\KategoriModel();
        $data = [
            'title' => 'Dashboard ' . $this->roleModel->getRoleBySlug($this->role)['label'],
            'user' => session()->get('user'),
            'data' => [
                'invoice_masuk' => 0,
                'invoice_keluar' => 0,
                'produk' => $produkModel->countAll(),
                'satuan' => $measurementModel->countAll(),
                'kategori' => $kategoriModel->countAll(),
            ]
        ];
        return view('dashboard/index', $data);
    }

    public function getScanner()
    {
        $data = [
            'title' => 'Dashboard ' . $this->roleModel->getRoleBySlug($this->role)['label'],
            'user' => session()->get('user'),
        ];
        return view('dashboard/scanner', $data);
    }

    public function getIssuing()
    {
        $invKeluarModel = new \App\Models\InvKeluarModel();
        $q = $this->request->getGet('q') == null ? '' : $this->request->getGet('q');
        $data = [
            'title' => 'Dashboard ' . $this->roleModel->getRoleBySlug($this->role)['label'],
            'user' => session()->get('user'),
            'data' => [
                'total' => $invKeluarModel->countAll(),
                'q' => $q,
                'invoices' => $invKeluarModel->like('referenceNumber', $q)->orLike('klien', $q)->orLike('deskripsi', $q)->orderBy('timestamp', 'DESC')->paginate(5),
            ],
            'pager' => $invKeluarModel->pager
        ];

        return view('dashboard/issuing', $data);
    }

    public function getReceiving()
    {
        $invMasuk = new \App\Models\InvMasukModel();
        $q = $this->request->getGet('q') == null ? '' : $this->request->getGet('q');
        $data = [
            'title' => 'Dashboard ' . $this->roleModel->getRoleBySlug($this->role)['label'],
            'user' => session()->get('user'),
            'data' => [
                'total' => $invMasuk->countAll(),
                'q' => $q,
                'invoices' => $invMasuk->like('referenceNumber', $q)->orLike('supplier', $q)->orLike('deskripsi', $q)->orderBy('timestamp', 'DESC')->paginate(5),
            ],
            'pager' => $invMasuk->pager
        ];
        return view('dashboard/receiving', $data);
    }

    public function getMeasurement()
    {
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

    public function getLaporan()
    {

        return view('dashboard/laporan');
    }
}
