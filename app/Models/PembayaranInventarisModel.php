<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranInventarisModel extends Model
{
    // db name
    protected $DBGroup = 'sik';

    /** table name */
    protected $table = "bayar_pemesanan_inventaris";

    /** primaryKey Field */
    protected $primaryKey = 'no_faktur';

    /** primaryKey autoincrement */
    //protected $useAutoIncrement = true;
    /** allowed Field */
    protected $allowedFields = ['tgl_bayar', 'no_faktur', 'nip', 'besar_bayar', 'keterangan', 'nama_bayar', 'no_bukti'];

    public function getData()
    {
        return $this->select('bayar_pemesanan_inventaris.*, petugas.*, akun_bayar_hutang.*')
            ->join('inventaris_pemesanan', 'bayar_pemesanan_inventaris.no_faktur = inventaris_pemesanan.no_faktur')
            ->join('petugas', 'bayar_pemesanan_inventaris.nip = petugas.nip')
            ->join('akun_bayar_hutang', 'bayar_pemesanan_inventaris.nama_bayar = akun_bayar_hutang.nama_bayar')
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
