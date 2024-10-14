<?php

namespace App\Models;

use CodeIgniter\Model;

class PenerimaanNonMedisDetailModel extends Model
{
    protected $DBGroup = 'sik'; // Sesuaikan jika berbeda
    protected $table = 'ipsrsdetailpesan';
    protected $primaryKey = 'no_faktur'; // Sesuaikan jika menggunakan ID sebagai primary key
    protected $allowedFields = ['no_faktur', 'kode_brng', 'kode_sat', 'jumlah', 'harga', 'subtotal', 'dis', 'besardis', 'total'];

    public function insertData($data)
    {
        return $this->insertBatch($data); // insert multiple rows at once
    }

    public function detailData($id)
    {
        return $this->select('ipsrsdetailpesan.*, ipsrsbarang.*, ipsrsjenisbarang.*')
            ->join('ipsrsbarang', 'ipsrsdetailbeli.kode_brng=ipsrsbarang.kode_brng')
            ->join('ipsrsjenisbarang', 'ipsrsbarang.jenis=ipsrsjenisbarang.kd_jenis')
            ->where('no_faktur', $id)
            ->findAll(); // retrieve all data
    }

    public function deleteDataByNoFaktur($id)
    {
        return $this->where('no_faktur', $id)->delete();
    }
}
