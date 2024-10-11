<?php

namespace App\Models;

use CodeIgniter\Model;

class PembelianNonMedisDetailModel extends Model
{
    protected $DBGroup = 'sik'; // Sesuaikan jika berbeda
    protected $table = 'inventaris_detail_beli';
    protected $primaryKey = 'no_faktur'; // Sesuaikan jika menggunakan ID sebagai primary key
    protected $allowedFields = ['no_faktur', 'kode_barang', 'jumlah', 'harga', 'subtotal', 'dis', 'besardis', 'total'];

    public function insertData($data)
    {
        return $this->insertBatch($data); // insert multiple rows at once
    }

    public function detailData($id)
    {
        return $this->select('inventaris_detail_beli.*, inventaris_barang.*, inventaris_produsen.*, inventaris_merk.*, inventaris_jenis.*')
        ->join('inventaris_barang','inventaris_detail_beli.kode_barang=inventaris_barang.kode_barang')
        ->join('inventaris_produsen','inventaris_barang.kode_produsen=inventaris_produsen.kode_produsen')
        ->join('inventaris_merk','inventaris_barang.id_merk=inventaris_merk.id_merk')
        ->join('inventaris_jenis','inventaris_barang.id_jenis=inventaris_jenis.id_jenis')
        ->where('no_faktur', $id)
        ->findAll(); // retrieve all data
    }

    public function deleteDataByNoFaktur($id)
    {
        return $this->where('no_faktur', $id)->delete();
    }
}
