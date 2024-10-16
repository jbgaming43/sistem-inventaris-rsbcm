<?php

namespace App\Models;

use CodeIgniter\Model;

class PermintaanNonMedisDetailModel extends Model
{
    // db name
    protected $DBGroup = 'sik';

    /** table name */
    protected $table = "detail_permintaan_non_medis";

    /** primaryKey Field */
    protected $primaryKey = 'no_permintaan';

    /** primaryKey autoincrement */
    //protected $useAutoIncrement = true;
    /** allowed Field */
    protected $allowedFields = ['no_permintaan', 'kode_brng', 'kode_sat', 'jumlah', 'keterangan'];

    public function getData()
    {
        return $this->select('detail_permintaan_non_medis.*, permintaan_non_medis.*, ipsrsbarang.*, kodesatuan.*')
            ->join('ipsrsbarang', 'detail_permintaan_non_medis.kode_brng=ipsrsbarang.kode_brng',)
            ->join('kodesatuan', 'detail_permintaan_non_medis.kode_sat=kodesatuan.kode_sat',)
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
        return $this->select('detail_permintaan_non_medis.*, permintaan_non_medis.*, ipsrsbarang.*, kodesatuan.*')
            ->join('ipsrsbarang', 'detail_permintaan_non_medis.kode_brng=ipsrsbarang.kode_brng',)
            ->join('kodesatuan', 'detail_permintaan_non_medis.kode_sat=kodesatuan.kode_sat',)
            ->where('no_permintaan', $id)
            ->findAll(); // retrieve all data
    }
}
