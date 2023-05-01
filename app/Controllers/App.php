<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class App extends BaseController
{
    public function index()
    {
        return redirect()->to('/user/login');
    }
}
