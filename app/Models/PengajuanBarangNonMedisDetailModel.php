<?php

namespace App\Models;

use CodeIgniter\Model;

class PengajuanBarangNonMedisDetailModel extends Model
{
    // db name
    protected $DBGroup = 'sik';

    /** table name */
    protected $table = "detail_pengajuan_barang_nonmedis";

    /** primaryKey Field */
    protected $primaryKey = 'no_pengajuan';

    /** primaryKey autoincrement */
    //protected $useAutoIncrement = true;
    /** allowed Field */
    protected $allowedFields = ['no_pengajuan','kode_brng', 'kode_sat', 'jumlah', 'h_pengajuan', 'total'];

    public function getData()
    {
        return $this->select('pengajuan_barang_nonmedis.*, pegawai.*')
        ->join('pegawai','pengajuan_barang_nonmedis.nip=pegawai.nik')
        ->findAll(); // retrieve all data
    }

    public function insertData($data)
    {
        return $this->insertBatch($data); // insert multiple rows at once
    }

    public function updateData($id, $data)
    {
        return $this->update($id, $data); // update data
    }

    public function deleteData($id)
    {
        return $this->delete($id); // delete data by ID
    }

    public function detailData($id)
    {
        return$this->select('detail_pengajuan_barang_nonmedis.*')
        ->where('no_pengajuan', $id)
        ->findAll(); // retrieve all data
    }
}
