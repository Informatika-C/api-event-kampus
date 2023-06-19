<?php
namespace App\Controllers\Peserta;

use App\Controllers\BaseController;
use App\Models\MyUserModel;
use CodeIgniter\Shield\Entities\UserIdentity;

class PesertaController extends BaseController
{
    public function index()
    {
        $userModel = new MyUserModel();
        $data = $userModel
            ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
            ->join('auth_identities', 'auth_identities.user_id = users.id')
            ->where('group', 'user')
            ->findAll();
        
        // convert data to array
        $data = array_map(function ($item) {
            return $item->toArray();
        }, $data);

        // filter data only id, username, secret, nama, npm, no_hp
        $data = array_map(function ($item) {
            return [
                'id' => $item['id'],
                'username' => $item['username'],
                'email' => $item['secret'],
                'nama' => $item['nama'],
                'npm' => $item['npm'],
                'no_hp' => $item['no_hp'],
            ];
        }, $data);

        return $this->response->setJSON($data);
    }
}