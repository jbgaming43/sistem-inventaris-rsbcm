<?php

namespace App\Models;

use CodeIgniter\Model;

class PengeluaranNonMedisModel extends Model
{
    // db name
    protected $DBGroup = 'sik';

    /** table name */
    protected $table = "ipsrspengeluaran";

    /** primaryKey Field */
    protected $primaryKey = 'no_keluar';

    /** primaryKey autoincrement */
    protected $useAutoIncrement = true;
    /** allowed Field */
    protected $allowedFields = ['no_keluar', 'tanggal', 'nip', 'keterangan'];

    public function getData()
    {
        return $this->select('ipsrspengeluaran.*, petugas.*')
            ->join('petugas', 'ipsrspengeluaran.nip = petugas.nip')
            ->findAll(); // Retrieve all data
    }

    public function getDataById($id)
    {
        return $this->select('ipsrspengeluaran.*, petugas.*')
            ->join('petugas', 'ipsrspengeluaran.nip = petugas.nip')
            ->where('no_keluar', $id)
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
