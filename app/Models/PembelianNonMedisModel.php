<?php

namespace App\Models;

use CodeIgniter\Model;

class PembelianNonMedisModel extends Model
{
    // db name
    protected $DBGroup = 'sik';

    /** table name */
    protected $table = "ipsrspembelian";

    /** primaryKey Field */
    protected $primaryKey = 'no_faktur';

    /** primaryKey autoincrement */
    //protected $useAutoIncrement = true;
    /** allowed Field */
    protected $allowedFields = ['no_faktur', 'kode_suplier', 'nip', 'tgl_beli', 'subtotal', 'potongan', 'total', 'ppn', 'meterai', 'tagihan', 'kd_rek'];

    public function getData()
    {
        return $this->select('ipsrspembelian.*, petugas.*, ipsrssuplier.*, rekening.*')
            ->join('petugas', 'ipsrspembelian.nip = petugas.nip')
            ->join('ipsrssuplier', 'ipsrspembelian.kode_suplier = ipsrssuplier.kode_suplier')
            ->join('rekening', 'ipsrspembelian.kd_rek = rekening.kd_rek')
            ->findAll(); // Retrieve all data
    }

    public function getDataById($id)
    {
        return $this->select('inventaris_pembelian.*, petugas.*, inventaris_suplier.*')
            ->join('petugas', 'inventaris_pembelian.nip=petugas.nip')
            ->join('inventaris_suplier', 'inventaris_pembelian.kode_suplier=inventaris_suplier.kode_suplier')
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