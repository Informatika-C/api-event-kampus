<?php

namespace App\Models;

use CodeIgniter\Model;

class PesertaKategori extends Model
{
    protected $table            = 'peserta_kategori';
    protected $primaryKey       = 'id_peserta_kategori';
    protected $allowedFields    = [
        'id_user',
        'id_kategori',
        'created_at',
    ];
}
