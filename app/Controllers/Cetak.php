<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

class Cetak extends BaseController
{
    public function getIssuing($id = null)
    {
        if (session()->get('user') == null) return redirect()->to('user/login');
        if ($id == null) return $this->badRequest('ID not found.');
        $pdf = new Pdfgenerator();
        $invoiceKeluarModel = new \App\Models\InvKeluarModel();
        $klienModel = new \App\Models\KlienModel();
        $penjualanModel = new \App\Models\PenjualanModel();
        $dataInvoice = $invoiceKeluarModel->select('*')->where('id', $id)->first();
        $dataKlien = $klienModel->select('*')->where('id', $dataInvoice['klien'])->first();
        $produk = $penjualanModel->select('*, (harga * kuantitas) as subtotal')->where('idInvoice', $id)->findAll();
        $data = [
            'title' => 'Invoice',
            'ref' => $dataInvoice['referenceNumber'],
            'pajak' => $dataInvoice['pajak'],
            'date' => strftime("%d %B %Y %H:%M:%S", $dataInvoice['timestamp'] / 1000),
            'klien' => $dataKlien,
            'products' => $produk
        ];
        $pdf->generate(view('cetak/issuing', $data), $data['title'], 'legal', 'portrait');
    }

    public function getLaporan()
    {
        if (session()->get('user') == null) return redirect()->to('user/login');
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
}
