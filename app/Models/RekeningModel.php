<?php

namespace App\Models;

use CodeIgniter\Model;

class RekeningModel extends Model
{
    // db name
    protected $DBGroup = 'sik';

    /** table name */
    protected $table = "rekening";

    /** primaryKey Field */
    protected $primaryKey = 'kd_rek';

    /** primaryKey autoincrement */
    //protected $useAutoIncrement = true;
    /** allowed Field */
    protected $allowedFields = ['kd_rek','nm_rek'];

    public function getData()
    {
        return $this->select('rekening.*')
        ->like('kd_rek', '1231')
        ->findAll();
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
