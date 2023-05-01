<?= $this->extend('layout/template') ?>
<?php $message = session()->getFlashdata('change_password_message') ?>
<?= $this->section('content') ?>
<?php
function validator($field)
{
    return array_key_exists($field, validation_errors()) ? "is-invalid" : '';
} ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 col-xl-5 mt-5 p-5">
            <h1 class="mb-3">Ubah Password</h1>
            <?php if ($message != null) : ?>
                <div class="alert alert-<?= $message['type'] ?> mb-3"><?= $message['message'] ?></div>
            <?php endif; ?>
            <form method="post" action="<?= base_url('user/changepassword') ?>">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input required type="text" value="<?= old('username') ?>" class="form-control <?= validator('username') ?>" name="username" id="username" aria-describedby="emailHelp">
                    <div class="invalid-feedback"><?= validation_show_error('username') ?></div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input required type="password" class="form-control" name="password" id="password">
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <a href="<?= base_url('user/login') ?>">Klik untuk login</a>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>