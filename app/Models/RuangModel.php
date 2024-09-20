<?php

namespace App\Models;

use CodeIgniter\Model;

class RuangModel extends Model
{
    protected $DBGroup = 'sik'; // Sesuaikan jika berbeda
    protected $table = 'inventaris_ruang';
    protected $primaryKey = 'id_ruang'; // Sesuaikan jika menggunakan ID sebagai primary key
    protected $allowedFields = ['id_ruang', 'nama_ruang'];
    public function getData()
    {
        return $this->select('inventaris_ruang.*')
            ->findAll(); // retrieve all data
    }
}
