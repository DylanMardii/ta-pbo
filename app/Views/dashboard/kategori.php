<?= $this->extend('dashboard/template') ?>
<?= $this->section('content') ?>
<div>
    <h3><i class="fa-solid fa-list"></i> KATEGORI</h3>
    <hr>
</div>
<div class="d-flex justify-content-between align-items-center">
    <div>
        <span>Total terdapat <b><?= $data['total'] ?></b> kategori.</span>
    </div>
    <div class="d-flex">
        <div class="me-3">
            <form action="">
                <input type="text" name="q" class="form-control" type="text" placeholder="Cari kategori" value="<?= $data['q'] ?>">
            </form>
        </div>
        <button type="button" class="btn btn-primary" id="btnTambahKategori">
            Tambah Kategori
        </button>
    </div>
</div>
<div class="modal fade" id="modalKategori" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" id="formKategori" class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Simpan data kategori</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="input-group row mx-0 mb-2">
                    <input type="hidden" name="idKategori" class="form-control" id="hInputIdKategori">
                    <div class="col">
                        <label for="Nama" class="form-label mt-0">Nama Kategori*</label>
                        <input required type="text" name="label" class="form-control" placeholder="Nama Kategori" id="inputNamaKategori">
                    </div>
                </div>
                <div class="input-group row mx-0 mb-2">
                    <div class="col">
                        <label for="inputDeskripsiKategori" class="form-label mt-0">Deskripsi</label>
                        <textarea type="text" name="deskripsi" class="form-control" placeholder="Deskripsi" id="inputDeskripsiKategori"></textarea>
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
            <?php if (count($data['kategori']) == 0) : ?>
                <tr>
                    <td colspan="8" class="text-center align-middle">Tidak ada kategori yang ditemukan. Klik tambah kategori baru untuk menambahkan.</td>
                </tr>
            <?php endif; ?>
            <?php $i = 1 ?>
            <?php foreach ($data['kategori'] as $kategori) : ?>
                <tr>
                    <td class="text-center align-middle"><?= $i ?>.</td>
                    <td class="text-center align-middle"><?= $kategori['label'] == "" ? '-' : $kategori['label'] ?></td>
                    <td class="text-center align-middle"><?= $kategori['deskripsi'] == "" ? '-' : $kategori['deskripsi'] ?></td>
                    <td class="text-center align-middle">
                        <button type="button" onclick="doc.prepareEditForm('<?= $kategori['id'] ?>')" class="btn btn-xs btn-primary text-white" title="Edit">
                            <i class="fa fa-pencil bigger-120"></i>
                        </button>
                        <button type="button" class="btn btn-xs btn-danger" href="#" title="Hapus kategori" onclick="doc.processDelete('<?= $kategori['label'] ?>', '<?= $kategori['id'] ?>')"><i class="fa-solid fa-trash-can bigger-120"></i></button>
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
            this.modalKategori = new bootstrap.Modal('#modalKategori');
            this.formKategori = $('#formKategori');
            this.hInputIdKategori = $('#hInputIdKategori');
            this.inputNamaKategori = $('#inputNamaKategori');
            this.inputDeskripsiKategori = $('#inputDeskripsiKategori');
            this.btnTambahKategori = $('#btnTambahKategori');

            const kategoriFlashMessage = JSON.parse(`<?= json_encode(session()->getFlashdata('kategori_message')) ?>`);
            if (kategoriFlashMessage != null) {
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
                    icon: kategoriFlashMessage.status,
                    title: kategoriFlashMessage.message
                })
            }
        }

        prepareInsertForm() {
            $("input").val('');
            $("textarea").val('');
            this.modalKategori.show();
        }

        async prepareEditForm(id) {
            this.hInputIdKategori.val(id);
            let res = await fetch('<?= base_url('kategori/data/') ?>' + id)
            res = await res.json();
            if (res.status != 'success') return alert('Terjadi kesalahan mengambil data kategori.');
            let data = res.data;
            Object.keys(data).forEach(key => {
                $("[name='" + key + "']").val(data[key]);
                $("[name='" + key + "']").trigger('change');
            });
            this.modalKategori.show();
        }

        async processDelete(name, id) {
            let isTrue = confirm(`Apakah anda benar ingin menghapus ${name}?`);
            if (isTrue) {
                let res = await fetch(`<?= base_url('kategori/delete/') ?>${id}`);
                window.location.href = '';
            }
        }
    } // end of class Document

    const doc = new Document();

    doc.formKategori.submit(async (e) => {
        fetch('/kategori', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: $('#formKategori').serialize()
        }).then((response) => response.json()).then((res) => {
            if (res.status != 'success') {
                return alert('Terjadi kesalahan mengirim data kategori.');
            } else {
                window.location.href = '';
            }

        });
        e.preventDefault();
        return false;
    });

    doc.btnTambahKategori.click(() => {
        doc.prepareInsertForm();
    });
</script>
<?= $this->endSection() ?>