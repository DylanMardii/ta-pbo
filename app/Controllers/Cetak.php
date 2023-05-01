<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

class Cetak extends BaseController
{
    public function index()
    {
        //
    }

    public function getLaporan()
    {
        $pdf = new Pdfgenerator();
        $produkModel = new \App\Models\ProdukModel();
        $produk = $produkModel->select('produk.*, kategori.label as kategori, satuan.label as satuan, (produk.harga_jual * produk.stok) as subtotal')
            ->join('kategori', 'kategori.id = produk.kategori', 'left')
            ->join('satuan', 'satuan.id = produk.satuan', 'left')
            ->orderBy('produk.nama', 'asc')->findAll();
        $data = [
            'title' => 'Laporan Stok Barang',
            'date' => strftime("%d %B %Y %H:%M:%S", time()),
            'total' => $produkModel->countAll(),
            'products' => $produk
        ];
        $pdf->generate(view('cetak/produk', $data), $data['title'], 'legal', 'portrait');
    }

    public function getPreview()
    {
        $pdf = new Pdfgenerator();
        $produkModel = new \App\Models\ProdukModel();
        $produk = $produkModel->select('produk.*, kategori.label as kategori, satuan.label as satuan, (produk.harga_jual * produk.stok) as subtotal')
            ->join('kategori', 'kategori.id = produk.kategori', 'left')
            ->join('satuan', 'satuan.id = produk.satuan', 'left')
            ->orderBy('produk.nama', 'asc')->findAll();
        $data = [
            'title' => 'Laporan Stok Barang',
            'date' => strftime("%d %B %Y %H:%M:%S", time()),
            'total' => $produkModel->countAll(),
            'products' => $produk
        ];
        return view('cetak/produk', $data);
    }
}
