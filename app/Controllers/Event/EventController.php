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

    public function create()
    {
        $model = new EventModel();
        $data = $this->request->getJSON();

        if ($model->insert($data)) {
            return $this->response->setJSON($data)->setStatusCode(201);
        } else {
            return $this->response->setStatusCode(400);
        }
    }

    public function update()
    {
        $id = $this->request->getUri()->getSegment(2);
        $model = new EventModel();
        $data = $this->request->getJSON();

        if ($model->update($id, $data)) {
            return $this->response->setJSON($data)->setStatusCode(200);
        } else {
            return $this->response->setStatusCode(400);
        }
    }

    public function delete()
    {
        $id = $this->request->getUri()->getSegment(2);
        $model = new EventModel();
        
        if ($model->delete($id)) {
            return $this->response->setStatusCode(200)->setJSON(['message' => 'Data berhasil dihapus']);
        } else {
            return $this->response->setStatusCode(400);
        }
    }

    public function find()
    {
        $id = $this->request->getUri()->getSegment(2);
        $model = new EventModel();
        $data = $model->find($id);

        return $this->response->setJSON($data);
    }
}