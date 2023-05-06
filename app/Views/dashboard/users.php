<?= $this->extend('dashboard/template') ?>
<?= $this->section('content') ?>
<div>
    <h3><i class="fa-solid fa-users"></i> USER MANAGEMENT</h3>
    <hr>
</div>
<div class="d-flex justify-content-between align-items-center">
    <div>
        <span>Total terdapat <b><?= $data['total'] ?></b> users.</span>
    </div>
    <div class="d-flex">
        <div class="me-3">
            <form action="">
                <input type="text" name="q" class="form-control" type="text" placeholder="Cari user" aria-label="Cari user" value="<?= $data['q'] ?>">
            </form>
        </div>
        <button type="button" class="btn btn-primary" onclick="prepareInsertForm();">
            Tambah User Baru
        </button>
    </div>
</div>
<div class="modal fade" id="userModal" role="dialog" tabindex="-1" aria-labelledby="submit" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" id="userForm" class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="submit">Simpan data user</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="input-group row mx-0 mb-2">
                    <input type="hidden" name="id" class="form-control" placeholder="id" aria-label="id" aria-describedby="basic-addon2" id="id">
                    <div class="col">
                        <label for="Nama" class="form-label mt-0">Nama*</label>
                        <input required type="text" name="name" class="form-control" placeholder="Nama" aria-label="Nama" aria-describedby="basic-addon2" id="Nama">
                    </div>
                    <div class="col">
                        <label for="Nama" class="form-label mt-0">Username*</label>
                        <input required type="text" name="username" class="form-control" placeholder="Nama" aria-label="Nama" aria-describedby="basic-addon2" id="Username">
                    </div>
                </div>
                <div class="input-group row mx-0 mb-2">
                    <div class="col">
                        <label for="roleSelect" class="form-label d-block mt-0" style="width: 100%;">Role</label>
                        <select required id="roleSelect" name="role" class="form-control">
                            <option disabled selected value>Pilih Role</option>
                            <?php foreach ($data['roles'] as $role) :  ?>
                                <option value="<?= $role['id'] ?>"><?= $role['label'] ?></option>
                            <?php endforeach;  ?>
                        </select>
                    </div>
                    <div class="col">
                        <label for="Nama" class="form-label mt-0">Password*</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon2" id="Password">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
<div class="mt-3"></div>
<div class="table-responsive">
    <table class="table table-light table-striped table-bordered table-responsive">
        <thead>
            <th class="text-center">No.</th>
            <!-- <th class="text-center">SKU</th> -->
            <th class="text-center">Nama</th>
            <th class="text-center">Username</th>
            <th class="text-center">Role</th>
            <!-- <th class="text-center">Avatar</th> -->
            <th class="text-center">Aksi</th>
        </thead>
        <tbody>
            <?php if (count($data['users']) == 0) : ?>
                <tr>
                    <td colspan="9" class="text-center align-middle">Tidak ada user yang ditemukan. Klik tambah user baru untuk menambahkan.</td>
                </tr>
            <?php endif; ?>
            <?php $i = 1 ?>
            <?php foreach ($data['users'] as $user) : ?>
                <tr>
                    <td class="text-center align-middle"><?= $i ?>.</td>
                    <td class="text-center align-middle"><?= htmlspecialchars($user['name']) ?></td>
                    <td class="text-center align-middle"><?= htmlspecialchars($user['username']) ?></td>
                    <td class="text-center align-middle"><?= htmlspecialchars($user['role']) ?></td>
                    <!-- <td class="text-center align-middle"><?= htmlspecialchars($user['avatar']) ?></td> -->
                    <td class="text-center align-middle">
                        <button type="button" onclick="prepareEditForm('<?= $user['id'] ?>')" class="btn btn-xs btn-primary text-white" title="Edit">
                            <i class="fa fa-pencil bigger-120"></i>
                        </button>
                        <button type="button" class="btn btn-xs btn-danger" href="#" title="Hapus user" onclick="processDelete('<?= htmlspecialchars($user['name']) ?>', '<?= $user['id'] ?>')"><i class="fa-solid fa-trash-can bigger-120"></i></button>
                    </td>
                </tr>
                <?php $i++ ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        <?= $pager->links() ?>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="<?= base_url('style/select2-bs4.min.css') ?>" rel="stylesheet">
</link>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const userFlashMessage = JSON.parse(`<?= json_encode(session()->getFlashdata('user_message')) ?>`);
    if (userFlashMessage != null) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: userFlashMessage.status,
            title: userFlashMessage.message
        })
    }

    const userModal = new bootstrap.Modal('#userModal')

    $("#userForm").submit(async (e) => {
        fetch('/user/dashboardRegistration', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: $('#userForm').serialize()
        }).then((response) => response.json()).then((res) => {
            window.location.href = '';
        });
        e.preventDefault();
        return false;
    });

    async function prepareInsertForm(id) {
        $("input:not([name='q'])").val('');
        $("select").val('');
        $("select").trigger('change');
        userModal.show();
    }

    async function prepareEditForm(id) {
        let res = await fetch('<?= base_url('user/data/') ?>' + id)
        res = await res.json();
        if (res.status != 'success') return alert('Terjadi kesalahan mengambil data user.');
        let data = res.data;
        Object.keys(data).forEach(key => {
            $("[name='" + key + "']").val(data[key]);
            $("[name='" + key + "']").trigger('change');
        });
        userModal.show();
    }

    async function processDelete(name, id) {
        let isTrue = confirm(`Apakah anda benar ingin menghapus\n${name}?`);
        if (isTrue) {
            let res = await fetch(`<?= base_url('user/delete/') ?>${id}`);
            window.location.href = '';
        }
    }
</script>
<?= $this->endSection() ?>