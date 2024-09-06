<?php

namespace App\Models;

use CodeIgniter\Model;

class InventarisBarangModel extends Model
{
    // db name
    protected $DBGroup = 'sik';
    
    /** table name */
    protected $table = "inventaris_barang";

    /** primaryKey Field */
    protected $primaryKey = 'kode_barang';

    /** primaryKey autoincrement */
    protected $useAutoIncrement = true;
    /** allowed Field */
    protected $allowedFields = ['kode_barang', 'nama_barang', 'jml_barang', 'kode_produsen', 'id_merk', 'thn_produksi', 'isbn', 'id_kategori', 'id_jenis'];

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

    public function getDataByKode($id)
    {
        return $this->select('inventaris_barang.*,inventaris_produsen.*, inventaris_merk.*,inventaris_jenis.*')
        ->join('inventaris_produsen','inventaris_barang.kode_produsen=inventaris_produsen.kode_produsen')
        ->join('inventaris_merk','inventaris_barang.id_merk=inventaris_merk.id_merk')
        ->join('inventaris_jenis','inventaris_barang.id_jenis=inventaris_jenis.id_jenis')
        ->where('inventaris_barang.kode_barang', $id)->first();
    }
}
