<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id';
    public $allowedFields = [
        'id_event',
        'kategori',
        'pendaftaran',
        'jam_awal_pendaftaran',
        'jam_akhir_pendaftaran',
        'penyisihan',
        'jam_awal_penyisihan',
        'jam_akhir_penyisihan',
        'pengumuman',
        'final',
    ];

    protected $validationRules = [
        'id_event' => 'required',
        'kategori' => 'required|min_length[3]|max_length[255]',
        'pendaftaran' => 'required|valid_date',
        'jam_awal_pendaftaran' => 'required|valid_date',
        'jam_akhir_pendaftaran' => 'required|valid_date',
        'penyisihan' => 'required|valid_date',
        'jam_awal_penyisihan' => 'required|valid_date',
        'jam_akhir_penyisihan' => 'required|valid_date',
        'pengumuman' => 'required|valid_date',
        'final' => 'required|valid_date',
    ];

    protected $validationMessages = [
        'id_event' => [
            'required' => 'ID event harus diisi.'
        ],
        'kategori' => [
            'required' => 'Kategori harus diisi.',
            'min_length' => 'Kategori minimal 3 karakter.',
            'max_length' => 'Kategori maksimal 255 karakter.'
        ],
        'pendaftaran' => [
            'required' => 'Tanggal pendaftaran harus diisi.',
            'valid_date' => 'Tanggal pendaftaran tidak valid.'
        ],
        'jam_awal_pendaftaran' => [
            'required' => 'Jam awal pendaftaran harus diisi.',
            'valid_date' => 'Jam awal pendaftaran tidak valid.'
        ],
        'jam_akhir_pendaftaran' => [
            'required' => 'Jam akhir pendaftaran harus diisi.',
            'valid_date' => 'Jam akhir pendaftaran tidak valid.'
        ],
        'penyisihan' => [
            'required' => 'Tanggal penyisihan harus diisi.',
            'valid_date' => 'Tanggal penyisihan tidak valid.'
        ],
        'jam_awal_penyisihan' => [
            'required' => 'Jam awal penyisihan harus diisi.',
            'valid_date' => 'Jam awal penyisihan tidak valid.'
        ],
        'jam_akhir_penyisihan' => [
            'required' => 'Jam akhir penyisihan harus diisi.',
            'valid_date' => 'Jam akhir penyisihan tidak valid.'
        ],
        'final' => [
            'required' => 'Tanggal final harus diisi.',
            'valid_date' => 'Tanggal final tidak valid.'
        ],
    ];
}