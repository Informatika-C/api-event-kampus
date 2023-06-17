<?php
namespace App\Controllers\Home;

use App\Controllers\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        $banner = glob("images/banner/*.*");

        return $this->response->setJSON([
            "banner" => $banner
        ]);
    }
}