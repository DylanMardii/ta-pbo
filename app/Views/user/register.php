<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<?= $message = session()->getFlashdata('registration_message') ?>
<?php
function validator($field)
{
    return array_key_exists($field, validation_errors()) ? "is-invalid" : '';
} ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 col-xl-5 mt-5 p-5">
            <h1>Buat akun</h1>
            <form method="post" action="<?= base_url('user/register') ?>" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input required type="text" value="<?= old('username') ?>" name="username" class="form-control <?= validator('username') ?>" id="username" />
                    <div class="invalid-feedback"><?= validation_show_error('username') ?></div>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input required type="text" value="<?= old('name') ?>" name="name" class="form-control <?= validator('name') ?>" id="name">
                    <div class="invalid-feedback"><?= validation_show_error('name') ?></div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input required type="password" value="<?= old('password') ?>" name="password" class="form-control <?= validator('password') ?>" id="password">
                    <div class="invalid-feedback"><?= validation_show_error('password') ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-sm-4">
                        <label for="Role" class="form-label">Role</label>
                        <select selected="<?= old('role') ?>" class="form-select <?= validator('role') ?>" name="role" aria-label="Role" id="Role">
                            <?php foreach ($data['roles'] as $role) :  ?>
                                <option value="<?= $role['id'] ?>"><?= $role['label'] ?></option>
                            <?php endforeach;  ?>
                        </select>
                        <div class="invalid-feedback"><?= validation_show_error('role') ?></div>
                    </div>
                    <div class="col-12 col-sm-8">
                        <label for="formFile" class="form-label ">Gambar Avatar</label>
                        <input class="form-control" type="file" name="avatar" id="formFile">
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="div">
                        <a href="<?= base_url('user/login') ?>">Klik untuk login</a>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>


            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>