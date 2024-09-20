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
            ->like('no_inventaris', 'INV-' . $tanggal, 'after')
            ->orderBy('no_inventaris', 'DESC')
            ->limit(1)
            ->first();
    }

    public function getDataById($id)
    {
        return $this->select('inventaris.*, inventaris.no_inventaris as no_inv, inventaris_barang.*, inventaris_ruang.*, inventaris_garansi.*, inventaris_detail_pesan.*, inventaris_pemesanan.*, inventaris_suplier.* ')
            ->join('inventaris_barang', 'inventaris.kode_barang=inventaris_barang.kode_barang')
            ->join('inventaris_ruang', 'inventaris.id_ruang=inventaris_ruang.id_ruang', 'left')
            ->join('inventaris_garansi', 'inventaris.no_inventaris=inventaris_garansi.no_inventaris', 'left')
            // join tambahan untuk mendapatkan suplier
            ->join('inventaris_detail_pesan', 'inventaris.kode_barang=inventaris_detail_pesan.kode_barang', 'left')
            ->join('inventaris_pemesanan', 'inventaris_detail_pesan.no_faktur=inventaris_pemesanan.no_faktur', 'left')
            ->join('inventaris_suplier', 'inventaris_pemesanan.kode_suplier=inventaris_suplier.kode_suplier', 'left')
            /// 
            ->where('inventaris.no_inventaris', $id)
            ->findAll(); // retrieve all data
    }

    public function getData()
    {
        return $this->select('inventaris.*, inventaris_barang.*')
            ->join('inventaris_barang', 'inventaris.kode_barang=inventaris_barang.kode_barang')
            ->findAll(); // retrieve all data
    }

    public function getDataBytgl_kd($tgl, $kd)
    {
        return $this->select('inventaris.*, inventaris_barang.*')
            ->join('inventaris_barang', 'inventaris.kode_barang=inventaris_barang.kode_barang')
            ->where('inventaris.tgl_pengadaan', $tgl)
            ->whereIn('inventaris.kode_barang', $kd)
            ->findAll(); // retrieve all data
    }

    public function updateRuang($id, $data)
    {
        return $this->where('no_inventaris',$id)
        ->set($data)
        ->update();
    }
}
