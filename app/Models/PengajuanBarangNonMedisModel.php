<?php

namespace App\Models;

use CodeIgniter\Model;

class PengajuanBarangNonMedisModel extends Model
{
    // db name
    protected $DBGroup = 'sik';

    /** table name */
    protected $table = "pengajuan_barang_nonmedis";

    /** primaryKey Field */
    protected $primaryKey = 'no_pengajuan';

    /** primaryKey autoincrement */
    //protected $useAutoIncrement = true;
    /** allowed Field */
    protected $allowedFields = ['nip', 'tanggal', 'status', 'keterangan'];

    public function getData()
    {
        return $this->select('pengajuan_barang_nonmedis.*, pegawai.*')
        ->join('pegawai','pengajuan_barang_nonmedis.nip=pegawai.nik')
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
