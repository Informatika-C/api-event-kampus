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
        $event_academic = $eventModel->where("tipe", "akademik")->findAll();
        $event_non_academic = $eventModel->where("tipe", "non-akademik")->findAll();

        return $this->response->setJSON([
            "banner" => $banner,
            "event" => $event,
            "event_academic" => $event_academic,
            "event_non_academic" => $event_non_academic,
        ]);
    }
}