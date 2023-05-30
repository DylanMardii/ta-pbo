<?= $this->extend('dashboard/template') ?>
<?= $this->section('content') ?>
<div>
    <h3><i class="fa-solid fa-cart-shopping"></i> PRODUK</h3>
    <hr>
</div>
<div class="d-flex justify-content-between align-items-center">
    <div>
        <span>Total terdapat <b><?= $data['total'] ?></b> produk.</span>
    </div>
    <div class="d-flex">
        <div class="me-3">
            <form action="">
                <input type="text" name="q" class="form-control" type="text" placeholder="Cari produk" aria-label="Cari produk" value="<?= $data['q'] ?>">
            </form>
        </div>
        <button type="button" class="btn btn-primary" onclick="prepareInsertForm();">
            Tambah Produk
        </button>
    </div>
</div>
<div class="modal fade" id="produkModal" role="dialog" tabindex="-1" aria-labelledby="submit" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" id="produkForm" class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="submit">Simpan data produk</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="input-group row mx-0 mb-2">
                    <input type="hidden" name="id" class="form-control" placeholder="id" aria-label="id" aria-describedby="basic-addon2" id="id">
                    <div class="col">
                        <label for="Nama" class="form-label mt-0">Nama*</label>
                        <input required type="text" name="nama" class="form-control" placeholder="Nama" aria-label="Nama" aria-describedby="basic-addon2" id="Nama">
                    </div>
                    <div class="col">
                        <label for="kategoriSelect" class="form-label d-block mt-0" style="width: 100%;">Kategori</label>
                        <select required id="kategoriSelect" name="kategori" class="form-control">
                            <option></option>
                            <?php foreach ($data['kategori'] as $kategori) :  ?>
                                <option value="<?= $kategori['id'] ?>"><?= $kategori['label'] ?></option>
                            <?php endforeach;  ?>
                        </select>
                    </div>
                </div>
                <div class="input-group row mx-0 mb-2">
                    <div class="col">
                        <label for="SKU" class="form-label mt-0">SKU</label>
                        <input type="text" name="sku" class="form-control" placeholder="SKU" aria-label="SKU" aria-describedby="basic-addon2" id="SKU">
                    </div>
                    <div class="col">
                        <label for="bar" class="form-label mt-0">Barcode</label>
                        <input type="text" name="barcode" class="form-control" placeholder="Barcode" aria-label="Barcode" aria-describedby="basic-addon2" id="inputBarcode">
                    </div>
                </div>
                <div class="input-group row mx-0 mb-2">
                    <div class="col">
                        <label for="Deskripsi" class="form-label mt-0">Deskripsi</label>
                        <input type="text" name="deskripsi" class="form-control" placeholder="Deskripsi" aria-label="Deskripsi" aria-describedby="basic-addon2" id="Deskripsi">
                    </div>
                    <div class="col">
                        <label for="Lokasi" class="form-label mt-0">Lokasi</label>
                        <input type="text" name="lokasi" class="form-control" placeholder="Lokasi" aria-label="Lokasi" aria-describedby="basic-addon2" id="Lokasi">
                    </div>
                </div>
                <div class="input-group row mx-0 mb-2">
                    <div class="col">
                        <label for="beli" class="form-label mt-0">Harga beli*</label>
                        <input required type="number" name="harga_beli" class="form-control" placeholder="Harga beli" aria-label="Harga beli" aria-describedby="basic-addon2" id="beli">
                    </div>
                    <div class="col">
                        <label for="jual" class="form-label mt-0">Harga jual*</label>
                        <input required type="number" name="harga_jual" class="form-control" placeholder="Harga jual" aria-label="Harga jual" aria-describedby="basic-addon2" id="jual">
                    </div>
                </div>
                <div class="input-group row mx-0 mb-2">
                    <div class="col">
                        <label for="Stok" class="form-label mt-0">Stok*</label>
                        <input required type="number" name="stok" class="form-control" placeholder="Stok" aria-label="Stok" aria-describedby="basic-addon2" id="stok">
                    </div>
                    <div class="col">
                        <label for="Satuan" class="form-label mt-0">Satuan*</label>
                        <select required id="satuanSelect" name="satuan" class="form-control">
                            <option></option>
                            <?php foreach ($data['satuan'] as $satuan) :  ?>
                                <option value="<?= $satuan['id'] ?>"><?= $satuan['label'] ?></option>
                            <?php endforeach;  ?>
                        </select>
                    </div>
                    <div class="col">
                        <label for="Dimensi" class="form-label mt-0">Dimensi</label>
                        <input type="text" name="dimensi" class="form-control" placeholder="Dimensi" aria-label="Dimensi" aria-describedby="basic-addon2" id="Dimensi">
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
            <th class="text-center">Barcode</th>
            <th class="text-center">Nama</th>
            <th class="text-center">Kategori</th>
            <th class="text-center">Lokasi</th>
            <th class="text-center">Harga Jual</th>
            <th class="text-center">Jumlah</th>
            <th class="text-center">Action</th>
        </thead>
        <tbody>
            <?php if (count($data['produk']) == 0) : ?>
                <tr>
                    <td colspan="9" class="text-center align-middle">Tidak ada produk yang ditemukan. Klik tambah produk baru untuk menambahkan.</td>
                </tr>
            <?php endif; ?>
            <?php $i = 1 ?>
            <?php foreach ($data['produk'] as $produk) : ?>
                <tr>
                    <td class="text-center align-middle"><?= $i ?>.</td>
                    <td class="text-center align-middle"><?= $produk['barcode'] == '' ? '<b><i>Tidak ada barcode.</i></b>' : '<img style="height: 60px" src="https://barcode.tec-it.com/barcode.ashx?data=' . $produk['barcode'] . '&code=EAN13&translate-esc=on" alt="' . $produk['barcode'] . '">' ?></td>
                    <td class="text-center align-middle"><?= htmlspecialchars($produk['nama']) ?></td>
                    <td class="text-center align-middle"><?= $produk['kategori'] ?></td>
                    <td class="text-center align-middle"><?= $produk['lokasi'] == "" ? '-' : $produk['lokasi'] ?></td>
                    <td class="text-center align-middle"><?= $produk['harga_jual'] ?></td>
                    <td class="text-center align-middle"><?= $produk['stok'] ?> <?= $produk['satuan'] ?></td>
                    <td class="text-center align-middle">
                        <button type="button" onclick="prepareEditForm('<?= $produk['id'] ?>')" class="btn btn-xs btn-primary text-white" title="Edit">
                            <i class="fa fa-pencil bigger-120"></i>
                        </button>
                        <button type="button" class="btn btn-xs btn-danger" href="#" title="Hapus produk" onclick="processDelete('<?= htmlspecialchars($produk['nama']) ?>', '<?= $produk['id'] ?>')"><i class="fa-solid fa-trash-can bigger-120"></i></button>
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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="<?= base_url('style/select2-bs4.min.css') ?>" rel="stylesheet">
</link>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const produkFlashMessage = JSON.parse(`<?= json_encode(session()->getFlashdata('produk_message')) ?>`);
    if (produkFlashMessage != null) {
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
            icon: produkFlashMessage.status,
            title: produkFlashMessage.message
        })
    }

    const produkModal = new bootstrap.Modal('#produkModal')

    $(document).ready(function() {
        $('#kategoriSelect').select2({
            placeholder: 'Kategori',
            theme: 'bootstrap4',
            dropdownParent: $("#produkModal"),
        });
        $('#satuanSelect').select2({
            placeholder: 'Satuan',
            theme: 'bootstrap4',
            dropdownParent: $("#produkModal"),
        });
    });

    $("#produkForm").submit(async (e) => {
        fetch('/produk', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: $('#produkForm').serialize()
        }).then((response) => response.json()).then((res) => {
            window.location.href = '/dashboard/produk';
        });
        e.preventDefault();
        return false;
    });

    async function prepareInsertForm(id) {
        $("input").val('');
        $("select").val('');
        $("select").trigger('change');
        produkModal.show();
    }

    async function prepareEditForm(id) {
        let res = await fetch('<?= base_url('produk/data/') ?>' + id)
        res = await res.json();
        if (res.status != 'success') return alert('Terjadi kesalahan mengambil data produk.');
        let data = res.data;
        Object.keys(data).forEach(key => {
            $("[name='" + key + "']").val(data[key]);
            $("[name='" + key + "']").trigger('change');
        });
        produkModal.show();
    }

    async function processDelete(name, id) {
        let isTrue = confirm(`Apakah anda benar ingin menghapus\n${name}?`);
        if (isTrue) {
            let res = await fetch(`<?= base_url('produk/delete/') ?>${id}`);
            window.location.href = '/dashboard/produk';
        }
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
            document.querySelector('#beepAudio').play();

            function containsOnlyNumbers(str) {
                return /^(\d+,)*(\d+)$/.test(str);
            }

            if (containsOnlyNumbers(data.barcode)) {
                $("#inputBarcode").val(data.barcode);
            } else {
                $("#SKU").val(data.barcode);
            }
        }
        set(dbRef, {
            barcode: ''
        })
    });
</script>
<?= $this->endSection() ?>