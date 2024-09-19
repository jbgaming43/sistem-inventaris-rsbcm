<?php

namespace App\Models;

use CodeIgniter\Model;

class InventarisModel extends Model
{
    protected $DBGroup = 'sik'; // Sesuaikan jika berbeda
    protected $table = 'inventaris';
    protected $primaryKey = 'no_inventaris'; // Sesuaikan jika menggunakan ID sebagai primary key
    protected $allowedFields = ['no_inventaris', 'kode_barang', 'asal_barang', 'tgl_pengadaan', 'harga', 'status_barang', 'id_ruang', 'no_rak', 'no_box'];

    public function insertData($data)
    {
        return $this->insert($data); // insert multiple rows at once
    }

    public function detailData($id)
    {
        return $this->select('inventaris.*, inventaris_barang.*, inventaris_ruang.*')
            ->join('inventaris_barang', 'inventaris.kode_barang=inventaris_barang.kode_barang')
            ->join('inventaris_ruang', 'inventaris.id_ruang=inventaris_ruang.id_ruang')
            ->where('no_inventaris', $id)
            ->findAll(); // retrieve all data
    }

    public function deleteDataByNoFaktur($id)
    {
        return $this->where('no_inventaris', $id)->delete();
    }

    public function getNoInventarisLast($tanggal)
    {
        if ($tanggal === null) {
            $tanggal = date('Ymd'); // Format tanggal default
        }
        return $this->select('inventaris.*')
            ->like('no_inventaris', 'INV/' . $tanggal, 'after')
            ->orderBy('no_inventaris', 'DESC')
            ->limit(1)
            ->first();
    }

    public function getDataById($id)
    {
        return $this->select('inventaris.*, inventaris_barang.*')
            ->join('inventaris_barang', 'inventaris.kode_barang=inventaris_barang.kode_barang')
            ->where('no_inventaris', $id)
            ->findAll(); // retrieve all data
    }

    public function getDataBytgl_kd($tgl, $kd)
    {
        // Mengonversi array $kode_barang_array menjadi string yang bisa digunakan di dalam IN()
        $kode_barang_str = "'" . implode("','", $kd) . "'";
        
        // Query SQL biasa
        $sql = "SELECT inventaris.*, inventaris_barang.*
            FROM inventaris
            JOIN inventaris_barang ON inventaris.kode_barang = inventaris_barang.kode_barang
            WHERE inventaris.tgl_pengadaan = '2024-09-17'";
             
        // Eksekusi query dan kembalikan hasilnya
        return $this->db->query($sql, [$tgl])->getResultArray();
    }
}
