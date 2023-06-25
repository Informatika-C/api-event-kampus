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

    public function updateName(){
        $nama = $this->request->getPost('nama');

        if(empty($nama)){
            return $this->response->setJSON([
                'errors' => 'Nama tidak boleh kosong',
            ])->setStatusCode(400);
        }

        $id_current_user = auth()->user()->id;
        $users = auth()->getProvider();
        $user = $users->findById($id_current_user);

        $user->fill([
            'nama' => $nama,
        ]);

        $users->save($user);

        if(count($users->errors()) > 0){
            return $this->response->setJSON([
                'errors' => $users->errors(),
            ])->setStatusCode(400);
        }

        return $this->response->setJSON([
            'message' => 'Berhasil mengubah nama',
        ]);
    }

    public function updateEmail(){
        $email = $this->request->getPost('email');

        if(empty($email)){
            return $this->response->setJSON([
                'errors' => 'Email tidak boleh kosong',
            ])->setStatusCode(400);
        }
        
        $rules = [
            'email'    => [
                'rules' => 'required|min_length[3]|max_length[255]|valid_email|is_unique[auth_identities.secret]',
                'errors' => [
                    'is_unique' => 'Email Sudah Digunakan',
                    'required' => 'Email Harus Diisi',
                    'min_length' => 'Email Minimal 3 Karakter',
                    'max_length' => 'Email Maksimal 255 Karakter',
                    'valid_email' => 'Email Tidak Valid',
                ],
            ],
        ];

        try{
            if (! $this->validateData($this->request->getPost(), $rules)) {
                return $this->response->setJSON(['errors' => $this->validator->getErrors()['email']])
                    ->setStatusCode(400);
            }
        }
        catch(\Exception $e){
            return $this->response->setJSON(['errors' => "Something went wrong"])
                ->setStatusCode(400);
        }


        $id_current_user = auth()->user()->id;
        $users = auth()->getProvider();
        $user = $users->findById($id_current_user);

        $user->fill([
            'email' => $email,
        ]);

        $users->save($user);

        if(count($users->errors()) > 0){
            return $this->response->setJSON([
                'errors' => $users->errors(),
            ])->setStatusCode(400);
        }

        return $this->response->setJSON([
            'message' => 'Berhasil mengubah email',
        ]);
    }

    public function updatePhone(){
        $phone = $this->request->getPost('no_hp');

        if(empty($phone)){
            return $this->response->setJSON([
                'errors' => 'Nomor Hp tidak boleh kosong',
            ])->setStatusCode(400);
        }

        $rules = [
            'no_hp' => [
                'rules' => 'required|is_unique[users.no_hp]',
                'errors' => [
                    'required' => 'No HP Harus Diisi',
                    'is_unique' => 'No HP Sudah Digunakan'
                ]
            ],
        ];

        try{
            if (! $this->validateData($this->request->getPost(), $rules)) {
                return $this->response->setJSON(['errors' => $this->validator->getErrors()['no_hp']])
                    ->setStatusCode(400);
            }
        }
        catch(\Exception $e){
            return $this->response->setJSON(['errors' => "Something went wrong"])
                ->setStatusCode(400);
        }

        $id_current_user = auth()->user()->id;
        $users = auth()->getProvider();
        $user = $users->findById($id_current_user);

        $user->fill([
            'no_hp' => $phone,
        ]);

        $users->save($user);

        if(count($users->errors()) > 0){
            return $this->response->setJSON([
                'errors' => $users->errors(),
            ])->setStatusCode(400);
        }

        return $this->response->setJSON([
            'message' => 'Berhasil mengubah nomor hp',
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
                'tanggal_pendaftaran' => $kategori['pendaftaran'],
                'tanggal_penyisihan' => $kategori['penyisihan'],
                'tanggal_final' => $kategori['final'],
            ];
        }

        return $this->response->setJSON($data);
    }
}