<?php

namespace App\Models;

use CodeIgniter\Model;

class PembelianInventarisDetailModel extends Model
{
    protected $DBGroup = 'sik'; // Sesuaikan jika berbeda
    protected $table = 'inventaris_detail_beli';
    protected $primaryKey = 'no_faktur'; // Sesuaikan jika menggunakan ID sebagai primary key
    protected $allowedFields = ['no_faktur', 'kode_barang', 'jumlah', 'harga', 'subtotal', 'dis', 'besardis', 'total'];

    public function insertData($data)
    {
        return $this->insertBatch($data); // insert multiple rows at once
    }
}
