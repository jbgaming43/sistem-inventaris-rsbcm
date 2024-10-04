<?php

namespace App\Models;

use CodeIgniter\Model;

class IpsrsBarangModel extends Model
{
    // db name
    protected $DBGroup = 'sik';

    /** table name */
    protected $table = "ipsrsbarang";

    /** primaryKey Field */
    protected $primaryKey = 'kode_brng';

    /** primaryKey autoincrement */
    //protected $useAutoIncrement = true;
    /** allowed Field */
    protected $allowedFields = ['kode_brng', 'nama_barang', 'kode_sat', 'jenis', 'stok', 'harga', 'status'];

    public function getData()
    {
        return $this->select('ipsrsbarang.*, ipsrsjenisbarang.*')
            ->join('ipsrsjenisbarang', 'ipsrsbarang.jenis=ipsrsjenisbarang.kd_jenis')
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

    public function getDataByKode($kode_barang)
    {
        return $this->select('ipsrsbarang.kode_brng, ipsrsbarang.nama_brng, ipsrsbarang.kode_sat, ipsrsjenisbarang.nm_jenis, ipsrsbarang.harga')
            ->join('ipsrsjenisbarang', 'ipsrsbarang.jenis = ipsrsjenisbarang.kd_jenis')
            ->where('ipsrsbarang.kode_brng', $kode_barang)
            ->first();
    }
}
