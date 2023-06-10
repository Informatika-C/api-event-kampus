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

    public function search()
    {
        // get all query key
        $query = $this->request->getGet();

        // array to object
        $query = (object) $query;

        $model = new EventModel();

        $queryData = $model;

        if(!(array) $query) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Query tidak sesuai']);
        }
        foreach($query as $key => $value) {
            if(!in_array($key, $model->allowedFields)) {
                return $this->response->setStatusCode(400)->setJSON(['message' => 'Query tidak sesuai']);
            }
        }

        if(isset($query->nama)) {
            $queryData = $queryData->like('nama', $query->nama);
        }
        if(isset($query->keterangan)) {
            $queryData = $queryData->orLike('keterangan', $query->keterangan);
        }
        if(isset($query->tanggal)) {
            $queryData = $queryData->orLike('tanggal', $query->tanggal);
        }
        if(isset($query->tempat)) {
            $queryData = $queryData->orLike('tempat', $query->tempat);
        }
        if(isset($query->penanggung_jawab)) {
            $queryData = $queryData->orLike('penanggung_jawab', $query->penanggung_jawab);
        }

        $queryData = $queryData->findAll();

        return $this->response->setJSON($queryData);
    }
}