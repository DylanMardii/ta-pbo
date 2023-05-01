<?php

function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}


function penyebut($nilai)
{
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " " . $huruf[$nilai];
    } else if ($nilai < 20) {
        $temp = penyebut($nilai - 10) . " belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
}

function terbilang($nilai)
{
    if ($nilai < 0) {
        $hasil = "minus " . trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }
    return $hasil;
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan stok barang</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Libre+Barcode+EAN13+Text&display=swap" rel="stylesheet">

    <style>
        div,
        p,
        span,
        tr,
        td,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Segoe UI', sans-serif;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-10 mt-2">
                <div class="d-flex flex-column align-items-center">
                    <div style="font-size: 24px; text-align:center; font-weight: 700">PT StockIn Indonesia</div>
                    <div style="font-size: 12px; text-align:center; margin-top: .25rem;">Jl. Dikenang Mantan No 5 Kec. Padadia Kab. Rumahnya Jawa Barat-12345</div>
                    <div style="font-size: 12px; text-align:center; margin-top: .25rem;">Tel: 0812-3456-7891 | WA: 0821-3456-8876 | E-Mail: mail@stockin.com </div>
                </div>
                <hr style="margin-bottom: 0;">
                <h5 style=" font-size: 18px; text-align: center; margin: 0; padding-bottom: 0; margin-top: 10px;">Laporan Stok Barang</h5>
                <p style="font-size: 12px; text-align: center; margin: 0; margin-top: .25rem; margin-bottom: .25rem;">Dicetak pada: <?= $date ?></p>
                <table style="border: 1px solid black; text-align: center; margin-top: .75rem; margin-bottom: .75rem; width: 100%;" cellspacing="0">
                    <thead>
                        <tr style="font-size: 12px;">
                            <th style="border: 1px solid black; padding: .25rem .25rem;">No</th>
                            <th style="border: 1px solid black; padding: .25rem .25rem;">Barcode</th>
                            <th style="border: 1px solid black; padding: .25rem .25rem;">Nama</th>
                            <th style="border: 1px solid black; padding: .25rem .25rem;">Kategori</th>
                            <th style="border: 1px solid black; padding: .25rem .25rem;">Jumlah</th>
                            <th style="border: 1px solid black; padding: .25rem .25rem;">Harga Beli (satuan)</th>
                            <th style="border: 1px solid black; padding: .25rem .25rem;">Harga Jual (satuan)</th>
                            <th style="border: 1px solid black; padding: .25rem .25rem;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        $totalJual = 0;
                        $totalBeli = 0; ?>
                        <?php foreach ($products as $produk) : ?>
                            <tr style="font-size: 12px;">
                                <td style="border: 1px solid black; padding: .25rem .25rem;" class="align-middle"><?= $i ?></td>
                                <td style="border: 1px solid black; padding: .25rem .25rem;" class="text-center align-middle"><?= $produk['barcode'] ?></td>
                                <td style="border: 1px solid black; padding: .25rem .25rem;" class="text-center align-middle"><?= htmlspecialchars($produk['nama']) ?></td>
                                <td style="border: 1px solid black; padding: .25rem .25rem;" class="text-center align-middle"><?= $produk['kategori'] ?></td>
                                <td style="border: 1px solid black; padding: .25rem .25rem;" class="text-center align-middle"><?= $produk['stok'] ?> <?= $produk['satuan'] ?></td>
                                <td style="border: 1px solid black; padding: .25rem .25rem;" class="text-center align-middle"><?= rupiah($produk['harga_beli']) ?></td>
                                <td style="border: 1px solid black; padding: .25rem .25rem;" class="text-center align-middle"><?= rupiah($produk['harga_jual']) ?></td>
                                <td style="border: 1px solid black; padding: .25rem .25rem;" class="text-center align-middle"><?= rupiah($produk['subtotal']) ?></td>
                            </tr>
                            <?php $i++;
                            $totalBeli += $produk['stok'] * $produk['harga_beli'];
                            $totalJual += $produk['stok'] * $produk['harga_jual']; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <table style="border: 1px solid white !important;">
                    <tr style="font-size: 12px;">
                        <th style="text-align:right;">Total barang</th>
                        <th class="pe-2">:</th>
                        <td><?= $total ?></td>
                    </tr>
                    <tr style="font-size: 12px;">
                        <th style="text-align:right;">Total harga jual</th>
                        <th class="pe-2">:</th>
                        <td><?= rupiah($totalJual) ?> (<?= terbilang($totalJual) ?> rupiah)</td>
                    </tr>
                    <tr style="font-size: 12px;">
                        <th style="text-align:right;">Total harga beli</th>
                        <th class="pe-2">:</th>
                        <td><?= rupiah($totalBeli) ?> (<?= terbilang($totalBeli) ?> rupiah)</td>
                    </tr>
                </table>
                <hr>
                <div class="d-flex justify-content-end">
                    <div class="align-items-end">
                        <div style="text-align: right;">
                            <div style="font-size: 14px; font-weight:700;margin-top:.5rem;">PT StockIn Indonesia</div>
                            <div style="font-size: 14px; margin-top:.5rem;">yang bertanda tangan di bawah ini</div>
                            <div style="font-size: 14px; margin-top: 5rem; font-weight:700;">Manager</div>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>

        </div>
    </div>
</body>

</html>