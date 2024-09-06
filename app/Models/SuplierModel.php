<?php

namespace App\Models;

use CodeIgniter\Model;

class SuplierModel extends Model
{
    // db name
    protected $DBGroup = 'sik';
    
    /** table name */
    protected $table = "inventaris_suplier";

    /** primaryKey Field */
    protected $primaryKey = 'kode_suplier';

    /** primaryKey autoincrement */
    protected $useAutoIncrement = true;
    /** allowed Field */
    protected $allowedFields = ['kode_suplier', 'nama_suplier'];

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
