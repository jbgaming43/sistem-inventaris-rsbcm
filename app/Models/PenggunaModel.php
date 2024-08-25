<?php

namespace App\Models;

use CodeIgniter\Model;

class PenggunaModel extends Model
{
    /** table name */
    protected $table = "tb_pengguna";

    /** primaryKey Field */
    protected $primaryKey = 'id';

    /** primaryKey autoincrement */
    protected $useAutoIncrement = true;
    /** allowed Field */
    protected $allowedFields = ['username', 'password', 'level', 'nama_pengguna', 'no_telp', 'profile_image', 'created_at'];

    public function getData()
    {
        return $this->findAll(); // retrieve all data
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
