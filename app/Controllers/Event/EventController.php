<?php
namespace App\Controllers\Event;

use App\Controllers\BaseController;
use App\Models\EventModel;

class EventController extends BaseController
{
    public function index()
    {
        $model = new EventModel();
        $AllData = $model->findAll();
        
        return $this->response->setJSON($AllData);
    }
}