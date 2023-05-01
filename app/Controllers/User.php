<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoleModel;
use CodeIgniter\Files\File;

class User extends BaseController
{
    protected $userModel;
    protected $roleModel;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
    }

    public function getIndex()
    {
        if (!session()->has('user')) return redirect()->to('user/login');
        $users = $this->userModel->findAll();
        $data = [
            'title' => 'User List',
            'users' => $users
        ];
        return view('user/list', $data);
    }

    public function getLogout()
    {
        session()->remove('user');
        session()->destroy();
        return redirect()->to('user/login');
    }

    public function getLogin()
    {
        if (session()->has('user')) return redirect()->to('dashboard');
        $data = [
            'title' => 'User Login'
        ];
        return view('user/login', $data);
    }

    public function postLogin()
    {
        if (session()->has('user')) return redirect()->to('dashboard');
        if (!$this->validate([
            'password' => 'required',
            'username' => 'required',
        ])) {
            return redirect()->to('user/login')->withInput();
        }
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $user = $this->userModel->select('user.*, role.slug as role')->where('username', $username)
            ->join('role', 'user.role = role.id', 'left')->first();
        if ($user) {
            if (password_verify((string) $password, $user['password'])) {
                session()->set('user', [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'name' => $user['name'],
                    'role' => $user['role'],
                    'avatar' => $user['avatar']
                ]);
                session()->setFlashdata('login_message', [
                    'type' => 'success',
                    'message' => 'Berhasil login.'
                ]);
                return redirect()->to('dashboard');
            } else {
                session()->setFlashdata('login_message', [
                    'type' => 'danger',
                    'message' => 'Password salah. Silakan coba lagi.'
                ]);
                return redirect()->to('user/login')->withInput();
            }
        } else {
            session()->setFlashdata('login_message', [
                'type' => 'danger',
                'message' => 'Username tidak ditemukan. Silakan coba lagi.'
            ]);
            return redirect()->to('user/login')->withInput();
        }
        return view('user/login');
    }

    public function getRegister()
    {
        $data = [
            'title' => 'User Registration',
            'data' => [
                'roles' => $this->roleModel->orderBy('label', 'asc')->findAll()
            ]
        ];
        return view('user/register', $data);
    }

    public function postRegister()
    {
        if (!$this->validate([
            'name' => 'required',
            'password' => 'required',
            'username' => 'required|is_unique[user.username]',
            'avatar' => 'is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/gif,image/png,image/webp]|max_size[avatar,1024]|max_dims[avatar,1024,768]'
        ])) {
            return redirect()->to('user/register')->withInput();
        }

        $id = 'user-' . md5(uniqid(rand(), true));
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $role = $this->request->getVar('role');

        $img = $this->request->getFile('avatar');
        $fileName = null;

        if ($img->getError() != 4 && !$img->hasMoved()) {
            $fileName = $img->getRandomName();
            $img->move('img/profile/', $fileName);
        }

        $this->userModel->insert([
            'id' => $id,
            'name' => $this->request->getVar('name'),
            'username' => $username,
            'password' => password_hash((string) $password, PASSWORD_DEFAULT),
            'role' => $role,
            'avatar' => $fileName
        ]);

        session()->setFlashdata('login_message', [
            'type' => 'success',
            'message' => 'Berhasil mendaftar. Silakan login.'
        ]);
        return redirect()->to('user/login');
    }

    public function getChangePassword()
    {
        $data = [
            'title' => 'Ubah password'
        ];
        return view('user/change_password', $data);
    }

    public function postChangePassword()
    {
        if (!$this->validate([
            'password' => 'required',
            'username' => 'required',
        ])) {
            return redirect()->to('user/changepassword')->withInput();
        }

        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $user = $this->userModel->where('username', $username)->first();
        if ($user) {
            $this->userModel->update($user['id'], [
                'password' => password_hash((string) $password, PASSWORD_DEFAULT)
            ]);
            session()->setFlashdata('change_password_message', [
                'type' => 'success',
                'message' => 'Berhasil mengubah password.'
            ]);
            return redirect()->to('user/changepassword');
        } else {
            session()->setFlashdata('change_password_message', [
                'type' => 'danger',
                'message' => 'User tidak ditemukan.'
            ]);
            return redirect()->to('user/changepassword');
        }
    }
}
