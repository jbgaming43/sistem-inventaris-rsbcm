<?php

namespace App\Models;

use CodeIgniter\Model;

class PegawaiModel extends Model
{
    // db name
    protected $DBGroup = 'sik';
    
    /** table name */
    protected $table = "pegawai";

    /** primaryKey Field */
    protected $primaryKey = 'id';

    /** primaryKey autoincrement */
    protected $useAutoIncrement = true;
    /** allowed Field */
    protected $allowedFields = ['nik', 'nama', 'jk', 'jbtn', 'departemen'];

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
