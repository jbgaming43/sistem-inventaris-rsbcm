<?php

namespace App\Models;

use CodeIgniter\Model;

class PenerimaanNonMedisModel extends Model
{
    // db name
    protected $DBGroup = 'sik';

    /** table name */
    protected $table = "ipsrspemesanan";

    /** primaryKey Field */
    protected $primaryKey = 'no_faktur';

    /** primaryKey autoincrement */
    //protected $useAutoIncrement = true;
    /** allowed Field */
    protected $allowedFields = ['no_faktur', 'no_order', 'kode_suplier', 'nip', 'tgl_pesan', 'tgl_faktur', 'tgl_tempo', 'total1', 'potongan', 'total2', 'ppn', 'meterai', 'tagihan', 'status'];

    public function getData()
    {
        return $this->select('ipsrspemesanan.*, petugas.*, inventaris_suplier.*')
            ->join('petugas', 'ipsrspemesanan.nip = petugas.nip')
            ->join('inventaris_suplier', 'ipsrspemesanan.kode_suplier = inventaris_suplier.kode_suplier')
            ->orderBy('tgl_pesan', 'DESC')
            ->findAll(); // Retrieve all data
    }


    public function getDataById($id)
    {
        return $this->select('ipsrspemesanan.*, petugas.*, inventaris_suplier.*')
            ->join('petugas', 'ipsrspemesanan.nip=petugas.nip')
            ->join('inventaris_suplier', 'ipsrspemesanan.kode_suplier=inventaris_suplier.kode_suplier')
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
