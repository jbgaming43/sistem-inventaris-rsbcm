<?php

namespace App\Models;

use CodeIgniter\Model;

class GaransiModel extends Model
{
    protected $DBGroup = 'sik'; // Sesuaikan jika berbeda
    protected $table = 'inventaris_garansi';
    protected $primaryKey = 'no_inventaris'; // Sesuaikan jika menggunakan ID sebagai primary key
    protected $allowedFields = ['no_inventaris', 'garansi'];
    public function insertData($data)
    {
        return $this->insert($data);
    }

    public function getDataById($id)
    {
        return $this->select('inventaris_garansi.*')
        ->where('no_inventaris', $id)
        ->findAll();
    }

    public function updateData($id,$data)
    {
        return $this->update($id,$data);
    }
}
