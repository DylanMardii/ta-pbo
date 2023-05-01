<?= $this->extend('dashboard/template') ?>
<?= $this->section('content') ?>
<h5>Please scan this QR to use the scanner!</h5>
<img class="mt-3" height="250" width="250" src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=STOCKIN:<?= session()->get('user')['id'] ?>" alt="">
<div class="d-block mt-3">DO NOT SHARE THIS CODE WITH ANYONE!</div>
<div class="d-block mt-1">After scanning, you can input data using the scanner!</div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
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
        set(dbRef, {
            barcode: ''
        })

    });
</script>
<?= $this->endSection() ?>