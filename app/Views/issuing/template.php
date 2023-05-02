<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row no-gutters">
        <nav class="navbar navbar-expand-lg navbar-light bg-dark sticky-top">
            <div class="container-fluid px-4">
                <a class="navbar-brand text-white fw-medium" href="#">Selamat Datang, <?= $user['name'] ?></a>
            </div>
        </nav>
        <div class="col-md-2 bg-dark pt-4 overflow-y-auto" style="height: calc(100vh - 3.5rem);">
            <ul class="nav flex-column px-2">
                <li class="nav-item">
                    <a class="text-decoration-none text-white fw-medium" href="<?= base_url('dashboard') ?>"><i class="me-2 fa-solid fa-fw fa-gauge"></i> Dashboard</a>
                    <hr style="height: 2px;" class="bg-white">
                </li>
                <?php if ($user['role'] == 'admin') :  ?>
                    <li class="nav-item">
                        <a class="text-decoration-none text-white fw-medium" href="<?= base_url('dashboard/users') ?>"> <i class="me-2 fa-solid fa-fw fa-users"></i> Manajemen User</a>
                        <hr style="height: 2px;" class="bg-white">
                    </li>
                <?php endif;  ?>
                <?php if ($user['role'] == 'manager') :  ?>
                    <li class="nav-item">
                        <a class="text-decoration-none text-white fw-medium" href="<?= base_url('dashboard/laporan') ?>"><i class="me-2 fa-solid fa-fw fa-chart-simple"></i> Laporan</a>
                        <hr style="height: 2px;" class="bg-white">
                    </li>
                <?php endif;  ?>
                <?php if ($user['role'] == 'operator') :  ?>
                    <li class="nav-item">
                        <a class="text-decoration-none text-white fw-medium" href="<?= base_url('dashboard/kategori') ?>"><i class="me-2 fa-solid fa-fw fa-list"></i> Kategori</a>
                        <hr style="height: 2px;" class="bg-white">
                    </li>
                    <li class="nav-item">
                        <a class="text-decoration-none text-white fw-medium" href="<?= base_url('dashboard/produk') ?>"><i class="me-2 fa-solid fa-fw fa-cart-shopping"></i> Produk</a>
                        <hr style="height: 2px;" class="bg-white">
                    </li>
                    <li class="nav-item">
                        <a class="text-decoration-none text-white fw-medium" href="<?= base_url('dashboard/measurement') ?>"><i class="me-2 fa-solid fa-fw fa-weight-scale"></i> Satuan</a>
                        <hr style="height: 2px;" class="bg-white">
                    </li>
                    <li class="nav-item">
                        <a class="text-decoration-none text-white fw-medium" href="<?= base_url('dashboard/receiving') ?>"><i class="me-2 fa-solid fa-fw fa-file-invoice"></i> Invoice Masuk</a>
                        <hr style="height: 2px;" class="bg-white">
                    </li>
                    <li class="nav-item">
                        <a class="text-decoration-none text-white fw-medium" href="<?= base_url('dashboard/issuing') ?>"><i class="me-2 fa-solid fa-fw fa-receipt"></i> Invoice Keluar</a>
                        <hr style="height: 2px;" class="bg-white">
                    </li>
                    <li class="nav-item">
                        <a class="text-decoration-none text-white fw-medium" href="<?= base_url('cetak/laporan') ?>"><i class="me-2 fa-solid fa-fw fa-chart-simple"></i> Laporan</a>
                        <hr style="height: 2px;" class="bg-white">
                    </li>
                <?php endif;  ?>
                <li class="nav-item">
                    <a class="text-decoration-none text-white fw-medium" href="<?= base_url('user/logout') ?>"><i class="me-2 fa-solid fa-fw fa-door-open"></i> Keluar</a>
                </li>
            </ul>
        </div>
        <div class="col-md-10 p-5 pt-5 overflow-y-auto" style="height: calc(100vh - 3.5rem);">
            <?= $this->renderSection('content') ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>