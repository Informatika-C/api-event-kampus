<?php

namespace App\Models;

use CodeIgniter\Shield\Models\UserModel;

class MyUserModel extends UserModel
{
   
    protected $allowedFields  = [
        'username',
        'status',
        'status_message',
        'active',
        'last_active',
        'deleted_at',
        'nama',
        'npm',
        'no_hp',
    ];
   
}