<?= $this->extend('dashboard/template') ?>
<?= $this->section('content') ?>
<div>
    <h3><i class="fa-solid fa-building"></i> Supplier</h3>
    <hr>
</div>
<div class="d-flex justify-content-between align-items-center">
    <div>
        <span>Total terdapat <b><?= $data['total'] ?></b> supplier.</span>
    </div>
    <div class="d-flex">
        <div class="me-3">
            <form action="">
                <input type="text" name="q" class="form-control" type="text" placeholder="Cari supplier" value="<?= $data['q'] ?>">
            </form>
        </div>
        <button type="button" class="btn btn-primary" id="btnTambahSupplier">
            Tambah Supplier
        </button>
    </div>
</div>
<div class="modal fade" id="modalSupplier" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" id="formSupplier" class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Simpan data supplier</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="input-group row mx-0 mb-2">
                    <input type="hidden" name="idSupplier" class="form-control" id="hInputIdSupplier">
                    <div class="col">
                        <label for="Nama" class="form-label mt-0">Nama Supplier*</label>
                        <input required type="text" name="nama" class="form-control" placeholder="Nama Supplier" id="inputNamaSupplier">
                    </div>
                </div>
                <div class="input-group row mx-0 mb-2">
                    <div class="col">
                        <label for="inputAlamat" class="form-label mt-0">Alamat</label>
                        <textarea type="text" name="alamat" class="form-control" placeholder="Alamat" id="inputAlamat"></textarea>
                    </div>
                </div>
                <div class="input-group row mx-0 mb-2">
                    <div class="col">
                        <label for="inputNomorTelepon" class="form-label mt-0">Nomor Telepon</label>
                        <input type="text" name="telepon" class="form-control" placeholder="Telepon Supplier" id="inputNomorTelepon">
                    </div>
                    <div class="col">
                        <label for="inputEmail" class="form-label mt-0">Email Supplier</label>
                        <input type="email" name="email" class="form-control" placeholder="Email Supplier" id="inputEmail">
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
            <th class="text-center">No</th>
            <th class="text-center">Nama</th>
            <th class="text-center">Alamat</th>
            <th class="text-center">Telepon</th>
            <th class="text-center">Email</th>
            <th class="text-center">Aksi</th>
        </thead>
        <tbody>
            <?php if (count($data['supplier']) == 0) : ?>
                <tr>
                    <td colspan="8" class="text-center align-middle">Tidak ada supplier yang ditemukan. Klik tambah supplier baru untuk menambahkan.</td>
                </tr>
            <?php endif; ?>
            <?php $i = 1 ?>
            <?php foreach ($data['supplier'] as $supplier) : ?>
                <tr>
                    <td class="text-center align-middle"><?= $i ?>.</td>
                    <td class="text-center align-middle"><?= $supplier['nama'] == "" ? '-' : $supplier['nama'] ?></td>
                    <td class="text-center align-middle"><?= $supplier['alamat'] == "" ? '-' : $supplier['alamat'] ?></td>
                    <td class="text-center align-middle"><?= $supplier['telepon'] == "" ? '-' : $supplier['telepon'] ?></td>
                    <td class="text-center align-middle"><?= $supplier['email'] == "" ? '-' : $supplier['email'] ?></td>
                    <td class="text-center align-middle">
                        <button type="button" onclick="doc.prepareEditForm('<?= $supplier['id'] ?>')" class="btn btn-xs btn-primary text-white" title="Edit">
                            <i class="fa fa-pencil bigger-120"></i>
                        </button>
                        <button type="button" class="btn btn-xs btn-danger" href="#" title="Hapus supplier" onclick="doc.processDelete('<?= $supplier['nama'] ?>', '<?= $supplier['id'] ?>')"><i class="fa-solid fa-trash-can bigger-120"></i></button>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    class Document {
        constructor() {
            this.modalSupplier = new bootstrap.Modal('#modalSupplier');
            this.formSupplier = $('#formSupplier');
            this.hInputIdSupplier = $('#hInputIdSupplier');
            this.inputNamaSupplier = $('#inputNamaSupplier');
            this.inputAlamat = $('#inputAlamat');
            this.btnTambahSupplier = $('#btnTambahSupplier');

            const supplierFlashMessage = JSON.parse(`<?= json_encode(session()->getFlashdata('supplier_message')) ?>`);
            if (supplierFlashMessage != null) {
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
                    icon: supplierFlashMessage.status,
                    title: supplierFlashMessage.message
                })
            }
        }

        prepareInsertForm() {
            $("input").val('');
            $("textarea").val('');
            this.modalSupplier.show();
        }

        async prepareEditForm(id) {
            this.hInputIdSupplier.val(id);
            let res = await fetch('<?= base_url('supplier/data/') ?>' + id)
            res = await res.json();
            if (res.status != 'success') return alert('Terjadi kesalahan mengambil data supplier.');
            let data = res.data;
            Object.keys(data).forEach(key => {
                $("[name='" + key + "']").val(data[key]);
                $("[name='" + key + "']").trigger('change');
            });
            this.modalSupplier.show();
        }

        async processDelete(name, id) {
            let isTrue = confirm(`Apakah anda benar ingin menghapus ${name}?`);
            if (isTrue) {
                let res = await fetch(`<?= base_url('supplier/delete/') ?>${id}`);
                window.location.href = '';
            }
        }
    } // end of class Document

    const doc = new Document();

    doc.formSupplier.submit(async (e) => {
        fetch('/supplier', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: $('#formSupplier').serialize()
        }).then((response) => response.json()).then((res) => {
            if (res.status != 'success') {
                return alert('Terjadi kesalahan mengirim data supplier.');
            } else {
                window.location.href = '';
            }

        });
        e.preventDefault();
        return false;
    });

    doc.btnTambahSupplier.click(() => {
        doc.prepareInsertForm();
    });
</script>
<?= $this->endSection() ?>