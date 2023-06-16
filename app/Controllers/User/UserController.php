<?php
namespace App\Controllers\User;

use App\Controllers\BaseController;

class UserController extends BaseController
{
    public function index()
    {
        $user = auth()->user();

        return $this->response->setJSON([
            'username' => $user->username,
            'email' => $user->email,
            'role' => $user->getGroups()[0],
        ]);
    }
}