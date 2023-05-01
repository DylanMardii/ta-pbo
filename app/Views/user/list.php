<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container">
    <h2>User List</h2>
    <a href="<?= base_url('user/logout') ?>">Logout</a>
</div>
<?= $this->endSection() ?>