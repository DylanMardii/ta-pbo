<?= $this->extend('dashboard/template') ?>
<?= $this->section('content') ?>
<div>
    <h3><i class="fa-solid fa-list"></i> Invoice Masuk</h3>
    <hr>
</div>
<div class="d-flex justify-content-between align-items-center">
    <div>
        <span>Total terdapat <b><?= $data['total'] ?></b> invoice.</span>
    </div>
    <div class="d-flex">
        <div class="me-3">
            <form action="">
                <input type="text" name="q" class="form-control" type="text" placeholder="Cari invoice" aria-label="Cari invoice" value="<?= $data['q'] ?>">
            </form>
        </div>
        <button type="button" class="btn btn-primary" onclick="prepareInsertForm();">
            Tambah Invoice Baru
        </button>
    </div>
</div>
<div class="modal fade" id="invoiceModal" role="dialog" tabindex="-1" aria-labelledby="submit" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" id="invoiceForm" class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="submit">Tambah invoice baru</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-2">
                    <div class="m-1">
                        <label for="Reference Number" class="form-label mt-0">Reference Number</label>
                        <input type="text" name="referenceNumber" class="form-control" placeholder="Reference Number" aria-label="Reference Number" aria-describedby="basic-addon2" id="referenceNumber">
                    </div>
                    <div class="m-1">
                        <label for="Waktu Masuk" class="form-label mt-0">Waktu masuk</label>
                        <input type="datetime-local" step="1" name="waktuMasuk" class="form-control" placeholder="Waktu Masuk" aria-label="Waktu Masuk" aria-describedby="basic-addon2" id="waktuMasuk">
                    </div>
                    <div class="m-1">
                        <label for="Supplier" class="form-label mt-0">Supplier</label>
                        <input type="text" name="supplier" class="form-control" placeholder="Supplier" aria-label="Supplier" aria-describedby="basic-addon2" id="supplier">
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
            <th class="text-center">No Referensi</th>
            <th class="text-center">Waktu Masuk</th>
            <th class="text-center">Supplier</th>
            <th class="text-center">Status</th>
            <th class="text-center">Aksi</th>
        </thead>
        <tbody>
            <?php if (count($data['invoices']) == 0) : ?>
                <tr>
                    <td colspan="8" class="text-center align-middle">Tidak ada invoice yang ditemukan. Klik tambah satuan baru untuk menambahkan.</td>
                </tr>
            <?php endif; ?>
            <?php $i = 1 ?>
            <?php foreach ($data['invoices'] as $inv) : ?>
                <tr>
                    <td class="text-center align-middle"><?= $i ?>.</td>
                    <td class="text-center align-middle"><span onclick=""><?= $inv['referenceNumber'] == "" ? '-' : $inv['referenceNumber'] ?></span></td>
                    <td class="text-center align-middle"><?= date("d M Y H:i:s ", $inv['timestamp'] / 1000) ?></td>
                    <td class="text-center align-middle"><?= $inv['supplier'] ?></td>
                    <td class="text-center align-middle"><?= $inv['deskripsi'] ?></td>
                    <td class="text-center align-middle">
                        <a role="button" href="<?= base_url('receiving/form/' . $inv['id']) ?>" class="btn btn-xs btn-primary text-white" title="Edit">
                            <i class="fa fa-pencil"></i>
                        </a>
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
<audio id="beepAudio">
    <source src="<?= base_url('beep.mp3') ?>" type="audio/mp3">
</audio>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
</link>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const invoiceModal = new bootstrap.Modal(document.getElementById('invoiceModal'), {
        keyboard: false
    });
    const receivingFlashMessage = JSON.parse(`<?= json_encode(session()->getFlashdata('receiving_message')) ?>`);
    if (receivingFlashMessage != null) {
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
            icon: receivingFlashMessage.status,
            title: receivingFlashMessage.message
        })
    }

    async function processDelete(name, id) {
        let isTrue = confirm(`Apakah anda benar ingin menghapus ${name}?`);
        if (isTrue) {
            let res = await fetch(`<?= base_url('receiving/delete/') ?>${id}`);
            window.location.href = '/dashboard/receiving';
        }
    }

    $("#invoiceForm").submit(async (e) => {
        fetch('/receiving', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `referenceNumber=${$('#referenceNumber').val()}&waktuMasuk=${new Date($('#waktuMasuk').val()).getTime()}&supplier=${$('#supplier').val()}`
        }).then((response) => response.json()).then((res) => {
            window.location.href = '/dashboard/receiving';
        });
        e.preventDefault();
        return false;
    });

    async function prepareInsertForm(id) {
        const d = new Date();
        d.setHours(new Date().getHours() + 7);
        $("input").val('');
        $("select").val('');
        $("select").trigger('change');
        $('#waktuMasuk').val(d.toISOString().slice(0, 19));
        invoiceModal.show();
    }
</script>
<script type="module">
    import {
        initializeApp
    } from "https://www.gstatic.com/firebasejs/9.20.0/firebase-app.js";
    import {
        getDatabase,
        ref,
        set,
        onValue
    } from "https://www.gstatic.com/firebasejs/9.20.0/firebase-database.js";
    const firebaseConfig = {
        apiKey: "AIzaSyBT1R9H4rVYfqvFUEqnGEqr3B69FFOTUfo",
        authDomain: "xena4-4cca0.firebaseapp.com",
        databaseURL: "https://xena4-4cca0.firebaseio.com",
        projectId: "xena4-4cca0",
        storageBucket: "xena4-4cca0.appspot.com",
        messagingSenderId: "1087042792371",
        appId: "1:1087042792371:web:0a939331278a4eac0f39c6"
    };
    const app = initializeApp(firebaseConfig);
    const db = getDatabase(app);
    const dbRef = ref(db, 'scannerSession/<?= session()->get('user')['id'] ?>');
    onValue(dbRef, (snapshot) => {
        const data = snapshot.val();
        if (data.barcode) {
            $("select").val(data.barcode);
            $("select").trigger('change');
            document.querySelector('#beepAudio').play();
            $("#referenceNumber").val(data.barcode);
        }

        set(dbRef, {
            barcode: ''
        })
    });
</script>
<?= $this->endSection() ?>