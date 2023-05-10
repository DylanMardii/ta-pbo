<?php $message = session()->getFlashdata('login_message') ?>
<?php
function validator($field)
{
    return array_key_exists($field, validation_errors()) ? "is-invalid" : '';
} ?>
<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 col-xl-5 mt-5 p-5">
            <h1 class="mb-3">Login Form</h1>
            <?php if ($message != null) : ?>
                <div class="alert alert-<?= $message['type'] ?> mb-3"><?= $message['message'] ?></div>
            <?php endif; ?>
            <form method="post" action="<?= base_url('user/login') ?>">
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
                        <a href="<?= base_url('user/register') ?>">Buat akun</a>
                        <a class="ms-3" href="<?= base_url('user/changepassword') ?>">Lupa password</a>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>