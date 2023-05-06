<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class App extends BaseController
{
    public function index()
    {
        return redirect()->to('/user/login');
    }

    public function NotFoundPage()
    {
        return view('errors/html/error_404', ['message' => 'Halaman tidak ditemukan. Silakan klik <a href="/">di sini</a> untuk kembali.']);
    }
}
