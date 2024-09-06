<?php

namespace App\Models;

use CodeIgniter\Model;

class AkunBayarModel extends Model
{
    // db name
    protected $DBGroup = 'sik';

    /** table name */
    protected $table = "akun_bayar";

    /** primaryKey Field */
    protected $primaryKey = 'nama_bayar';

    /** primaryKey autoincrement */
    //protected $useAutoIncrement = true;
    /** allowed Field */
    protected $allowedFields = ['nama_bayar','kd_rek','ppn'];

    public function getData()
    {
        return $this->findAll();
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
