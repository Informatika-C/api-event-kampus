<?php

namespace App\Controllers;

class LogoutController extends BaseController
{
    
    public function index()
    {
        auth()->logout();
        return $this->response->setJSON(['message'=>'Logout Berhasil'])->setStatusCode(200);
    }

}