<?php

namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
    protected $table            = 'event';
    protected $primaryKey       = 'id_event';
    protected $useAutoIncrement = true;
    public $allowedFields    = ['nama', 'keterangan', 'tanggal', 'tempat', 'penanggung_jawab', 'gambar_poster', 'gambar_banner'];

    // Validation
    protected $validationRules      = [
        'nama' => 'required|is_unique[event.nama]|min_length[3]|max_length[255]',
        'keterangan' => 'required',
        'tanggal' => 'required|valid_date',
        'tempat' => 'required|min_length[3]|max_length[255]',
        'penanggung_jawab' => 'required|min_length[3]|max_length[255]',
        'gambar_poster' => 'required',
        'gambar_banner' => 'required'
    ];
    protected $validationMessages   = [
        'nama' => [
            'required' => 'Nama event harus diisi.',
            'is_unique' => 'Nama event sudah terdaftar.',
            'min_length' => 'Nama event minimal 3 karakter.',
            'max_length' => 'Nama event maksimal 255 karakter.'
        ],
        'keterangan' => [
            'required' => 'Keterangan event harus diisi.'
        ],
        'tanggal' => [
            'required' => 'Tanggal event harus diisi.',
            'valid_date' => 'Tanggal event tidak valid.'
        ],
        'tempat' => [
            'required' => 'Tempat event harus diisi.',
            'min_length' => 'Tempat event minimal 3 karakter.',
            'max_length' => 'Tempat event maksimal 255 karakter.'
        ],
        'penanggung_jawab' => [
            'required' => 'Penanggung jawab event harus diisi.',
            'min_length' => 'Penanggung jawab event minimal 3 karakter.',
            'max_length' => 'Penanggung jawab event maksimal 255 karakter.'
        ],
        'gambar_poster' => [
            'required' => 'Gambar poster event harus diisi.'
        ],
        'gambar_banner' => [
            'required' => 'Gambar banner event harus diisi.'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
