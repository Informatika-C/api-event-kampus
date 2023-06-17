<?php
namespace App\Controllers\User;

use App\Controllers\BaseController;

class UserController extends BaseController
{
    public function index()
    {
        $user = auth()->user();

        return $this->response->setJSON([
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'role' => $user->getGroups()[0],
            'nama' => $user->nama,
            'npm' => $user->npm,
            'no_hp' => $user->no_hp,
        ]);
    }
}