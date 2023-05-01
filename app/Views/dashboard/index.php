<?= $this->extend('dashboard/template') ?>
<?= $this->section('content') ?>
<h3 class="fw-bold"><i class="fa-solid fa-gauge mr-2"></i> DASHBOARD</h3>
<hr>
<div class="row gap-3">
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title fw-semibold">Barang Keluar</h5>
            <div class="display-4"><?= $data['produk'] ?></div>
            <p class="card-text"></p>
        </div>
    </div>
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title fw-semibold">Barang Masuk</h5>
            <div class="display-4"><?= $data['produk'] ?></div>
            <p class="card-text"></p>
        </div>
    </div>
    <div class="col gx-0">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title fw-semibold">Produk</h5>
                <div class="display-4"><?= $data['produk'] ?></div>
                <p class="card-text"></p>
            </div>
        </div>
        <div class="card mt-2" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title fw-semibold">Satuan</h5>
                <div class="display-4"><?= $data['satuan'] ?></div>
                <p class="card-text"></p>
            </div>
        </div>
        <div class="card mt-2" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title fw-semibold">Kategori</h5>
                <div class="display-4"><?= $data['kategori'] ?></div>
                <p class="card-text"></p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>