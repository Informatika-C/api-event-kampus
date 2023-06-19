<?php
namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\EventModel;
use App\Models\KategoriModel;
use App\Models\PesertaKategori;
use PDO;

class UserController extends BaseController
{
    public function index()
    {
        $user = auth()->user();

        return $this->response->setJSON([
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'role' => $user->getGroups()[0],
            'nama' => $user->nama,
            'npm' => $user->npm,
            'no_hp' => $user->no_hp,
        ]);
    }

    public function history(){
        $modelPesertaKategori = new PesertaKategori();
        $pesertaKategori = $modelPesertaKategori->where('id_user', auth()->user()->id)->findAll();

        $modelKategori = new KategoriModel();
        $modelEvent = new EventModel();
        $data = [];
        foreach ($pesertaKategori as $key => $value) {
            $kategori = $modelKategori->find($value['id_kategori']);
            $event = $modelEvent->find($kategori['id_event']);
            $data[] = [
                'id_event' => $event['id_event'],
                'nama_event' => $event['nama_event'],
                'gambar_poster' => $event['gambar_poster'],
                'id_kategori' => $kategori['id_kategori'],
                'nama_kategori' => $kategori['nama_kategori'],
                'tanggal' => $value['created_at'],
            ];
        }

        return $this->response->setJSON($data);
    }
}