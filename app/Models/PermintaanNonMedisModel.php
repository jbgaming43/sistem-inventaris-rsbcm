<?php

namespace App\Models;

use CodeIgniter\Model;

class PermintaanNonMedisModel extends Model
{
    // db name
    protected $DBGroup = 'sik';

    /** table name */
    protected $table = "permintaan_non_medis";

    /** primaryKey Field */
    protected $primaryKey = 'no_permintaan';

    /** primaryKey autoincrement */
    //protected $useAutoIncrement = true;
    /** allowed Field */
    protected $allowedFields = ['no_permintaan', 'ruang', 'nip', 'tanggal', 'status'];

    public function getData()
    {
        return $this->select('permintaan_non_medis.*, pegawai.*')
            ->join('pegawai', 'permintaan_non_medis.nip=pegawai.nik',)
            ->orderBy('tanggal', 'DESC')
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

    public function getDataById($id)
    {
        return  $this->select('permintaan_non_medis.*, pegawai.*')
            ->join('pegawai', 'permintaan_non_medis.nip=pegawai.nik')
            ->where('no_permintaan', $id)
            ->findAll(); // retrieve all data
    }
}
