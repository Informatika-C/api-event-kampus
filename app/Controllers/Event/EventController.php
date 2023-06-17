<?php
namespace App\Controllers\Event;

use App\Controllers\BaseController;
use App\Models\EventModel;

class EventController extends BaseController
{
    public function index()
    {
        $eventModel = new EventModel();
        $event = $eventModel->findAll();
        $event_academic = $eventModel->where("tipe", "akademik")->findAll();
        $event_non_academic = $eventModel->where("tipe", "non-akademik")->findAll();

        return $this->response->setJSON([
            "event" => $event,
            "event_academic" => $event_academic,
            "event_non_academic" => $event_non_academic,
        ]);
    }

    public function create()
    {
        $model = new EventModel();
        $data = [
            'nama_event' => $this->request->getPost("nama_event"),
            'tipe' => $this->request->getPost("tipe"),
            'keterangan' => $this->request->getPost("keterangan"),
            'tanggal' => $this->request->getPost("tanggal"),
            'tempat' => $this->request->getPost("tempat"),
            'penanggung_jawab' => $this->request->getPost("penanggung_jawab"),
            'gambar_poster' => $this->request->getFile("gambar_poster"),
            'gambar_banner' => $this->request->getFile("gambar_banner"),
        ];
        
        foreach ($data as $key => $value) {
            if ($key == 'gambar_poster' && $value != '-') {
                if ($value->isValid()) {
                    $poster = $value->getRandomName();
                    $value->move(FCPATH . 'public/images/poster', $poster);
                    $data['gambar_poster'] = 'images/poster/' . $poster;
                } else {
                    // Tangani kesalahan unggah gambar poster
                }
            } elseif ($key == 'gambar_banner' && $value != '-') {
                if ($value->isValid()) {
                    $banner = $value->getRandomName();
                    $value->move(FCPATH . 'public/images/banner-event', $banner);
                    $data['gambar_banner'] = 'images/banner-event/' . $banner;
                } else {
                    // Tangani kesalahan unggah gambar banner
                }
            }
        }
        

        try{
            if ($model->insert($data)) {
                return $this->response->setJSON($data)->setStatusCode(201);
            } else {
                return $this->response->setJSON(['message'=>'Data Tidak Valid'])->setStatusCode(400);
            }
        }
        catch (\Exception $e) {
            return $this->response->setJSON(['message'=>'Data Tidak Valid'])->setStatusCode(400);
        }
        
    }

    public function update()
    {
        $id = $this->request->getUri()->getSegment(2);
        $model = new EventModel();
        $data = $this->request->getJSON();

        try{
            if ($model->update($id, $data)) {
                return $this->response->setJSON($data)->setStatusCode(200);
            } else {
                return $this->response->setJSON(['message'=>'Data Tidak Valid'])->setStatusCode(400);
            }
        }
        catch (\Exception $e) {
            return $this->response->setJSON(['message'=>'Data Tidak Valid'])->setStatusCode(400);
        }
    }

    public function delete()
    {
        $id = $this->request->getUri()->getSegment(2);
        $model = new EventModel();

        // check if id is exist
        if($model->find($id) == null) {
            return $this->response->setStatusCode(404)->setJSON(['message' => 'Data tidak ditemukan']);
        }
        
        try{
            if ($model->delete($id)) {
                return $this->response->setStatusCode(200)->setJSON(['message' => 'Data berhasil dihapus']);
            } else {
                return $this->response->setStatusCode(404)->setJSON(['message' => 'Data tidak ditemukan']);
            }
        }
        catch (\Exception $e) {
            return $this->response->setStatusCode(404)->setJSON(['message' => 'Data tidak ditemukan']);
        }
    }

    public function find()
    {
        $id = $this->request->getUri()->getSegment(2);
        $model = new EventModel();

        $data = $model->find($id);

        if($data == null) {
            return $this->response->setStatusCode(404)->setJSON(['message' => 'Data tidak ditemukan']);
        }

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