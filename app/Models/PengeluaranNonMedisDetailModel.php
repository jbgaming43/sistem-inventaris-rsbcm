<?php

namespace App\Models;

use CodeIgniter\Model;

class PengeluaranNonMedisDetailModel extends Model
{
    // db name
    protected $DBGroup = 'sik';

    /** table name */
    protected $table = "ipsrsdetailpengeluaran";

    /** primaryKey Field */
    protected $primaryKey = 'no_keluar';

    /** primaryKey autoincrement */
    protected $useAutoIncrement = true;
    /** allowed Field */
    protected $allowedFields = ['no_keluar', 'kode_brng', 'kode_sat', 'jumlah', 'harga', 'total'];

    public function insertData($data)
    {
        return $this->insertBatch($data); // insert multiple rows at once
    }

    public function detailData($id)
    {
        return $this->select('ipsrsdetailpengeluaran.*, ipsrspengeluaran.*, ipsrsbarang.*')
            ->join('ipsrspengeluaran', 'ipsrsdetailpengeluaran.no_keluar=ipsrspengeluaran.no_keluar')
            ->join('ipsrsbarang', 'ipsrsdetailpengeluaran.kode_brng=ipsrsbarang.kode_brng')
            ->join('kodesatuan', 'ipsrsdetailpengeluaran.kode_sat=kodesatuan.kode_sat')
            ->join('ipsrsjenisbarang', 'ipsrsbarang.jenis=ipsrsjenisbarang.kd_jenis',)
            ->where('no_keluar', $id)
            ->findAll(); // retrieve all data
    }

    public function deleteDataByNoKeluar($id)
    {
        return $this->where('no_keluar', $id)->delete();
    }
}
