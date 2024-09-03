<?php

namespace App\Models;

use CodeIgniter\Model;

class PengajuanInventarisModel extends Model
{
    // db name
    protected $DBGroup = 'sik';

    /** table name */
    protected $table = "pengajuan_inventaris";

    /** primaryKey Field */
    protected $primaryKey = 'no_pengajuan';

    /** primaryKey autoincrement */
    //protected $useAutoIncrement = true;
    /** allowed Field */
    protected $allowedFields = ['no_pengajuan','tanggal', 'nik', 'urgensi', 'latar_belakang', 'nama_barang', 'spesifikasi', 'jumlah', 'harga', 'total', 'keterangan', 'nik_pj', 'status'];

    public function getData()
    {
        return $this->select('pengajuan_inventaris.*, pegawai.*')
        ->join('pegawai','pengajuan_inventaris.nik=pegawai.nik')
        ->join('pegawai as pj','pengajuan_inventaris.nik_pj=pj.nik')
        ->select('pj.nik as nik_pj,pj.nama as nama_pj')
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

    public function printData($tanggal_awal, $tanggal_akhir, $nik = null)
    {
        $builder = $this->select('pengajuan_inventaris.*, pegawai.*')
        ->join('pegawai','pengajuan_inventaris.nik=pegawai.nik')
        ->join('pegawai as pj','pengajuan_inventaris.nik_pj=pj.nik')
        ->select('pj.nik as nik_pj,pj.nama as nama_pj')
        ->where('tanggal >=' , $tanggal_awal)
        ->where('tanggal <=' , $tanggal_akhir);
        if ($nik != null){
            $builder->where('pengajuan_inventaris.nik', $nik);
        }
        return $builder->findAll(); // retrieve all data
    }
}
