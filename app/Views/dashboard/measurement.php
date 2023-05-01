<?= $this->extend('dashboard/template') ?>
<?= $this->section('content') ?>
<div>
    <h3><i class="fa-solid fa-list"></i> Satuan</h3>
    <hr>
</div>
<div class="d-flex justify-content-between align-items-center">
    <div>
        <span>Total terdapat <b><?= $data['total'] ?></b> satuan.</span>
    </div>
    <div class="d-flex">
        <div class="me-3">
            <form action="">
                <input type="text" name="q" class="form-control" type="text" placeholder="Cari satuan" aria-label="Cari satuan" value="<?= $data['q'] ?>">
            </form>
        </div>
        <button type="button" class="btn btn-primary" id="btnTambahSatuan">
            Tambah Satuan
        </button>
    </div>
</div>
<div class="modal fade" id="modalMeasurement" role="dialog" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" id="formMeasurement" class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalTitle">Simpan data satuan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="input-group row mx-0 mb-2">
                    <input type="hidden" name="id" class="form-control" placeholder="id" aria-label="id" aria-describedby="basic-addon2" id="hiddenIdMeasurement">
                    <div class="col">
                        <label for="Nama" class="form-label mt-0">Nama Satuan*</label>
                        <input required type="text" name="label" class="form-control" placeholder="Nama Satuan" id="inputNamaSatuan">
                    </div>
                </div>
                <div class="input-group row mx-0 mb-2">
                    <div class="col">
                        <label for="Nama" class="form-label mt-0">Deskripsi</label>
                        <textarea type="text" name="deskripsi" class="form-control" placeholder="Deskripsi" id="inputDeskripsiSatuan"></textarea>
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
            <th class="text-center">Deskripsi</th>
            <th class="text-center">Aksi</th>
        </thead>
        <tbody>
            <?php if (count($data['measurement']) == 0) : ?>
                <tr>
                    <td colspan="8" class="text-center align-middle">Tidak ada satuan yang ditemukan. Klik tambah satuan baru untuk menambahkan.</td>
                </tr>
            <?php endif; ?>
            <?php $i = 1 ?>
            <?php foreach ($data['measurement'] as $satuan) : ?>
                <tr>
                    <td class="text-center align-middle"><?= $i ?>.</td>
                    <td class="text-center align-middle"><span onclick=""><?= $satuan['label'] == "" ? '-' : $satuan['label'] ?></span></td>
                    <td class="text-center align-middle"><?= $satuan['deskripsi'] == "" ? '-' : $satuan['deskripsi'] ?></td>
                    <td class="text-center align-middle">
                        <button type="button" onclick="doc.prepareEditForm('<?= $satuan['id'] ?>')" class="btn btn-xs btn-primary text-white" title="Edit">
                            <i class="fa fa-pencil bigger-120"></i>
                        </button>
                        <button type="button" class="btn btn-xs btn-danger" href="#" title="Hapus satuan" onclick="doc.processDelete('<?= $satuan['label'] ?>', '<?= $satuan['id'] ?>')"><i class="fa-solid fa-trash-can bigger-120"></i></button>
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
            this.modalMeasurement = new bootstrap.Modal('#modalMeasurement');
            this.formMeasurement = $('#formMeasurement');
            this.hiddenIdMeasurement = $('#hiddenIdMeasurement');
            this.inputNamaSatuan = $('#inputNamaSatuan');
            this.inputDeskripsiSatuan = $('#inputDeskripsiSatuan');
            this.btnTambahSatuan = $('#btnTambahSatuan');

            const measurementFlashMessage = JSON.parse(`<?= json_encode(session()->getFlashdata('measurement_message')) ?>`);
            if (measurementFlashMessage != null) {
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
                    icon: measurementFlashMessage.status,
                    title: measurementFlashMessage.message
                })
            }
        }

        prepareInsertForm() {
            $("input").val('');
            $("textarea").val('');
            this.modalMeasurement.show();
        }

        async prepareEditForm(id) {
            let res = await fetch('<?= base_url('measurement/data/') ?>' + id)
            res = await res.json();
            if (res.status != 'success') return alert('Terjadi kesalahan mengambil data satuan.');
            let data = res.data;
            Object.keys(data).forEach(key => {
                $("[name='" + key + "']").val(data[key]);
                $("[name='" + key + "']").trigger('change');
            });
            this.modalMeasurement.show();
        }

        async processDelete(name, id) {
            let isTrue = confirm(`Apakah anda benar ingin menghapus ${name}?`);
            if (isTrue) {
                let res = await fetch(`<?= base_url('measurement/delete/') ?>${id}`);
                window.location.href = '';
            }
        }
    } // end of class Document

    const doc = new Document();

    doc.formMeasurement.submit(async (e) => {
        fetch('/measurement', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: $('#formMeasurement').serialize()
        }).then((response) => response.json()).then((res) => {
            window.location.href = '';
        });
        e.preventDefault();
        return false;
    });

    doc.btnTambahSatuan.click(() => {
        doc.prepareInsertForm();
    });
</script>
<?= $this->endSection() ?>