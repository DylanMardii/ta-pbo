<?= $this->extend('dashboard/template') ?>
<?= $this->section('content') ?>
<div class="modal fade" id="inputProdukModal" role="dialog" tabindex="-1" aria-labelledby="submit" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-red-500">
            <form method="post" id="inputProdukForm">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Tambah produk dengan scanner</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group row mx-0 mb-2">
                        <div class="col-3">
                            <label for="Jumlah" class="form-label mt-0">Jumlah</label>
                            <input required type="number" min="1" name="label" class="form-control" placeholder="Jumlah" aria-label="Jumlah" aria-describedby="basic-addon2" id="modalInputJumlah">
                        </div>
                        <div class="col-9">
                            <label for="Nama" class="form-label mt-0">Barcode / SKU</label>
                            <input required type="text" name="barcode" class="form-control" placeholder="Barcode" aria-describedby="basic-addon2" id="modalInputBarcode">
                        </div>
                        <input type="submit" hidden />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row-cols-1 ">
    <h3><i class="fa-solid fa-file-invoice"></i> INVOICE MASUK</h3>
    <hr>
    <form class="input-group mb-2" method="post" id="invoiceForm">
        <input type="hidden" name="id" id="invoiceId" value="<?= $data['invoice']['id'] ?>">
        <div class="m-1">
            <label for="Reference Number" class="form-label mt-0">Nomor Referensi</label>
            <input required type="text" name="referenceNumber" value="<?= $data['invoice']['referenceNumber'] ?>" class="form-control" placeholder="Reference Number" aria-label="Reference Number" aria-describedby="basic-addon2" id="referenceNumber">
        </div>
        <div class="m-1">
            <label for="Waktu Masuk" class="form-label mt-0">Waktu masuk</label>
            <input required type="datetime-local" name="waktuMasuk" value="<?= date('Y-m-d\TH:i:s', $data['invoice']['timestamp'] / 1000) ?>" class="form-control" placeholder="Waktu Masuk" aria-label="Waktu Masuk" aria-describedby="basic-addon2" id="waktuMasuk">
        </div>
        <div class="m-1">
            <label for="Supplier" class="form-label mt-0">Supplier</label>
            <select name="supplier" class="form-select" style="width: 270px;" value="" aria-label="Role" id="selectSupplier">
                <?php foreach ($data['supplier'] as $supplier) :  ?>
                    <option value="<?= $supplier['id'] ?>"><?= $supplier['nama'] ?></option>
                <?php endforeach;  ?>
            </select>
        </div>
        <div class="m-1">
            <label for="Status" class="form-label mt-0">Status</label>
            <input required type="text" name="status" class="form-control" value="<?= $data['invoice']['deskripsi'] ?>" placeholder="Status" aria-label="Status" aria-describedby="basic-addon2" id="status">
        </div>
        <div class="m-1 d-inline-flex align-items-end">
            <div class="d-inline">
                <button class="btn btn-warning" type="submit">Simpan</button>
            </div>
            <div class="d-inline">
                <button type="button" class="btn btn-danger ms-2" onclick="processDeleteInvoice('Apakah anda yakin ingin menghapus invoice ini?', '<?= $data['invoice']['id'] ?>')">Hapus</button>
            </div>
        </div>
    </form>
    <div class="d-flex">
        <div class="d-flex justify-start align-items-end">
            <div class="input-group">
                <div class="m-1">
                    <label for="barang" class="form-label mt-0">Barang</label>
                    <select required class="form-select" style="width: 300px;" aria-label="Role" id="selectBarang">
                    </select>
                </div>
                <div class="m-1 ms-2">
                    <label for="Jumlah" class="form-label mt-0">Jumlah</label>
                    <input required type="number" min="1" class="form-control" style="width: 7rem;" placeholder="Jumlah" aria-label="Jumlah" aria-describedby="basic-addon2" id="amount">
                </div>
            </div>
            <button class="btn btn-primary m-1 ms-2" onclick="processAddProduct()">
                <i class="fa-solid fa-plus"></i>
            </button>
            <button class="btn btn-warning m-1 ms-2" onclick="prepareScannerForm()">
                <i class="fa-solid fa-qrcode"></i>
            </button>
        </div>
    </div>
</div>
<style>
    table,
    th,
    td {
        border: 1px solid black;
    }
</style>
<div class="mt-3"></div>
<table style="width:100%" class="table table-striped table-light text-center">
    <thead>
        <th>Barcode</th>
        <th>Nama Barang</th>
        <th>Jumlah</th>
        <th>Harga per pcs</th>
        <th>Aksi</th>
    </thead>
    <tbody>

        <?php if (count($data['items']) == 0) : ?>
            <tr>
                <td colspan="8" class="text-center align-middle">Tidak ada entri untuk invoice ini.</td>
            </tr>
        <?php endif; ?>

        <?php $i = 1 ?>
        <?php foreach ($data['items'] as $item) : ?>
            <tr>
                <td class="align-middle"><?= $item['barcode'] ?></td>
                <td class="align-middle"><?= $item['nama'] ?></td>
                <td class="align-middle"><?= $item['kuantitas'] ?></td>
                <td class="align-middle"><?= $item['harga'] ?></td>
                <td class="align-middle">
                    <button type="button" class="btn btn-xs btn-danger" href="#" title="delete" onclick="processDeleteItem('<?= $item['id'] ?>', '<?= $item['nama'] ?>')"><i class="fa-solid fa-trash-can bigger-120"></i></button>
                </td>
            </tr>
            <?php $i++ ?>
        <?php endforeach; ?>
    </tbody>
</table>
<audio id="beepAudio">
    <source src="<?= base_url('beep.mp3') ?>" type="audio/mp3">
</audio>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="<?= base_url('style/select2-bs4.min.css') ?>" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const inputProdukModal = new bootstrap.Modal('#inputProdukModal');
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


    function formatItem(repo) {
        if (repo.loading) {
            return repo.text;
        }

        return repo.nama;
    }

    function formatItemSelection(repo) {
        return repo.nama || repo.text;
    }

    $(document).ready(function() {
        $('#selectBarang').select2({
            placeholder: 'Pilih barang',
            theme: 'bootstrap4',
            minimumInputLength: 1,
            templateResult: formatItem,
            templateSelection: formatItemSelection,
            ajax: {
                url: '<?= base_url('produk') ?>',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                    };
                },
                processResults: function(data, params) {
                    return {
                        results: data.data
                    };
                },
            }
        });
        $('#selectSupplier').select2({
            placeholder: 'Pilih klien',
            theme: 'bootstrap4',
        });
        $("#selectSupplier").val('<?= $data['invoice']['supplier'] ?>').trigger("change");
    });

    async function processDeleteInvoice(name, id) {
        let isTrue = confirm(`Apakah anda benar ingin menghapus invoice ini?`);
        if (isTrue) {
            let res = await fetch(`<?= base_url('receiving/delete/') ?>${id}`);
            window.location.href = '/dashboard/receiving';
        }
    }

    function prepareScannerForm() {
        $("#modalInputJumlah").val('');
        $("#modalInputBarcode").val('');
        inputProdukModal.show();
    }

    async function processAddProduct() {
        let idProduct = $('#selectBarang').val();
        let amount = $('#amount').val();
        let invoiceId = $('#invoiceId').val();

        if (!idProduct) {
            return alert('Silakan input barang yang diinginkan.');
        }

        if (!amount) {
            return alert('Silakan input jumlah barang.');
        }

        if (amount < 1) {
            return alert('Jumlah barang harus lebih dari sama dengan 1.');
        }

        fetch('/receiving/addProduct', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${invoiceId}&idProduct=${idProduct}&amount=${amount}`
        }).then((response) => response.json()).then((res) => {
            window.location.href = `/receiving/form/${$('#invoiceId').val()}`;
        });
        return false;
    }

    async function processDeleteItem(entryId, productName) {
        let isTrue = confirm(`Apakah anda benar ingin menghapus ${productName}?\nStok produk akan dikembalikan ke semula.`);
        if (isTrue) {
            fetch('/receiving/deleteProduct', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${entryId}`
            }).then((response) => response.json()).then((res) => {
                window.location.href = `/receiving/form/${$('#invoiceId').val()}`;
            });
        }
        return false;
    }

    $("#invoiceForm").submit(async (e) => {
        fetch('/receiving', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${$('#invoiceId').val()}&referenceNumber=${$('#referenceNumber').val()}&supplier=${$('#selectSupplier').val()}&status=${$('#status').val()}&waktuMasuk=${new Date($('#waktuMasuk').val()).getTime()}`
        }).then((response) => response.json()).then((res) => {
            window.location.href = `/receiving/form/${$('#invoiceId').val()}`;
        });
        e.preventDefault();
        return false;
    });
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
            console.log($("inputProdukModal").data('bs.modal')?._isShown);
            if ($("#inputProdukModal").is(':visible')) {
                $("#modalInputBarcode").val(data.barcode);
                $("#inputProdukForm").submit();
            }
        }
        set(dbRef, {
            barcode: ''
        })
    });

    $(document).on('keyup', (e) => {
        if (e.keyCode == 113) {
            inputProdukModal.show();
        }
    })

    $("#inputProdukModal").on('shown.bs.modal', () => {
        $("#modalInputJumlah").focus();
    })

    $("#inputProdukForm").submit(async (e) => {
        let idProduct = $('#modalInputBarcode').val();
        let amount = $('#modalInputJumlah').val() || 1;
        let invoiceId = $('#invoiceId').val();

        if (!idProduct) {
            return alert('Silakan input barang yang diinginkan.');
        }

        if (!amount) {
            return alert('Silakan input jumlah barang.');
        }

        if (amount < 1) {
            return alert('Jumlah barang harus lebih dari sama dengan 1.');
        }

        fetch('/receiving/addProduct', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${invoiceId}&idProduct=${idProduct}&amount=${amount}`
        }).then((response) => response.json()).then((res) => {
            window.location.href = `/receiving/form/${$('#invoiceId').val()}`;
        });
        e.preventDefault();
        return false;
    });
</script>
<?= $this->endSection() ?>