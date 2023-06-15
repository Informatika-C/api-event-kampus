<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
class LogoutController extends BaseController
{
    
    public function index()
    {
        auth()->logout();
        return $this->response->setJSON(['message'=>'Logout Berhasil'])->setStatusCode(200);
    }

}