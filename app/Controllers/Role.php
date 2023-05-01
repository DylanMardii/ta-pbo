<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Role extends BaseController
{
    protected $roleModel;
    public function __construct()
    {
        $this->roleModel = new \App\Models\RoleModel();
    }

    public function postNew()
    {
        $this->response->setHeader('Content-Type', 'application/json');
        $label = $this->request->getVar('label');
        $id = 'role-' . substr(md5(microtime()), rand(0, 26), 5);
        $role = $this->roleModel->like('label', $label, 'both', null, true)->first();
        if ($role) {
            return json_encode([
                'success' => false,
                'message' => 'Role sudah ada.',
            ]);
        }
        $this->roleModel->insert([
            'id' => $id,
            'label' => $label,
            'slug' => url_title($label, '-', true)
        ]);
        return json_encode([
            'success' => true,
            'message' => 'Berhasil membuat role baru.',
            'data' => [
                'id' => $id,
                'label' => $label
            ]
        ]);
    }

    public function postUpdate()
    {
        //
    }

    public function getIndex()
    {
        //
    }
}
