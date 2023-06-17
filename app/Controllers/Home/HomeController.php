<?php
namespace App\Controllers\Home;

use App\Controllers\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        $banner = glob("images/banner/*.*");
        $eventModel = new \App\Models\EventModel();
        $event = $eventModel->findAll();

        return $this->response->setJSON([
            "banner" => $banner,
            "event" => $event
        ]);
    }
}