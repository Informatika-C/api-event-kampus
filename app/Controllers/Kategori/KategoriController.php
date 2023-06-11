<?php
namespace App\Controllers\Kategori;

use App\Controllers\BaseController;
use App\Models\KategoriModel;

class KategoriController extends BaseController
{
    public function index()
    {
        $model = new KategoriModel();
        $AllData = $model->findAll();

        return $this->response->setJSON($AllData);
    }

    public function insert()
    {
        $model = new KategoriModel();
        $data = $this->request->getJSON();

        try{
            if ($model->insert($data)) {
                return $this->response->setJSON($data)->setStatusCode(201);
            } else {
                return $this->response->setJSON($model->errors())->setStatusCode(400);
            }
        }
        catch (\Exception $e) {
            return $this->response->setJSON(['message'=>'Data Tidak Valid'])->setStatusCode(400);
        }
    }

    public function update()
    {
        $id = $this->request->getUri()->getSegment(2);
        $model = new KategoriModel();
        $data = $this->request->getJSON();

        try{
            if ($model->update($id, $data)) {
                $data_update = $model->find($id);
                return $this->response->setJSON($data_update)->setStatusCode(200);
            } else {
                return $this->response->setJSON($model->errors())->setStatusCode(400);
            }
        }
        catch (\Exception $e) {
            return $this->response->setJSON(['message'=>'Data Tidak Valid'])->setStatusCode(400);
        }
    }

    public function delete()
    {
        $id = $this->request->getUri()->getSegment(2);
        $model = new KategoriModel();

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
        $model = new KategoriModel();

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

        $model = new KategoriModel();

        $queryData = $model;

        if(!(array) $query) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Query tidak sesuai']);
        }
        foreach($query as $key => $value) {
            if(!in_array($key, $model->allowedFields)) {
                return $this->response->setStatusCode(400)->setJSON(['message' => 'Query tidak sesuai']);
            }
        }

        if(isset($query->id_event)) {
            $queryData = $queryData->like('id_event', $query->id_event);
        }
        if(isset($query->kategori)) {
            $queryData = $queryData->like('kategori', $query->kategori);
        }
        if(isset($query->pendaftaran)) {
            $queryData = $queryData->like('pendaftaran', $query->pendaftaran);
        }
        if(isset($query->jam_awal_pendaftaran)) {
            $queryData = $queryData->like('jam_awal_pendaftaran', $query->jam_awal_pendaftaran);
        }
        if(isset($query->jam_akhir_pendaftaran)) {
            $queryData = $queryData->like('jam_akhir_pendaftaran', $query->jam_akhir_pendaftaran);
        }
        if(isset($query->penyisihan)) {
            $queryData = $queryData->like('penyisihan', $query->penyisihan);
        }
        if(isset($query->jam_awal_penyisihan)) {
            $queryData = $queryData->like('jam_awal_penyisihan', $query->jam_awal_penyisihan);
        }
        if(isset($query->jam_akhir_penyisihan)) {
            $queryData = $queryData->like('jam_akhir_penyisihan', $query->jam_akhir_penyisihan);
        }
        if(isset($query->pengumuman)) {
            $queryData = $queryData->like('pengumuman', $query->pengumuman);
        }
        if(isset($query->final)) {
            $queryData = $queryData->like('final', $query->final);
        }
        
        $queryData = $queryData->findAll();

        return $this->response->setJSON($queryData);
    }
}