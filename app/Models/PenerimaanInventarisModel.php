<?php

namespace App\Models;

use CodeIgniter\Model;

class PenerimaanInventarisModel extends Model
{
    // db name
    protected $DBGroup = 'sik';

    /** table name */
    protected $table = "inventaris_pemesanan";

    /** primaryKey Field */
    protected $primaryKey = 'no_faktur';

    /** primaryKey autoincrement */
    //protected $useAutoIncrement = true;
    /** allowed Field */
    protected $allowedFields = ['no_faktur', 'no_order','kode_suplier', 'nip', 'tgl_pesan','tgl_faktur', 'tgl_tempo', 'total1', 'potongan', 'total2', 'ppn', 'meterai', 'tagihan', 'status', 'kd_rek_aset'];

    public function getData()
    {
        return $this->select('inventaris_pemesanan.*, petugas.*, inventaris_suplier.*, rekening.*')
            ->join('petugas', 'inventaris_pemesanan.nip = petugas.nip')
            ->join('inventaris_suplier', 'inventaris_pemesanan.kode_suplier = inventaris_suplier.kode_suplier')
            ->join('rekening ', 'inventaris_pemesanan.kd_rek_aset = rekening.kd_rek')
            ->findAll(); // Retrieve all data
    }


    public function getDataById($id)
    {
        return $this->select('inventaris_pemesanan.*, petugas.*, inventaris_suplier.*')
            ->join('petugas', 'inventaris_pemesanan.nip=petugas.nip')
            ->join('inventaris_suplier', 'inventaris_pemesanan.kode_suplier=inventaris_suplier.kode_suplier')
            ->where('no_faktur', $id)
            ->findAll(); // retrieve all data
    }

    public function insertData($data)
    {
        return $this->insert($data); // insert data
    }

    public function updateData($id, $data)
    {
        return $this->update($id, $data); // update data
    }

    public function deleteData($id)
    {
        return $this->delete($id); // delete data by ID
    }
}
