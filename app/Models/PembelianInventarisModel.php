<?php

namespace App\Models;

use CodeIgniter\Model;

class PembelianInventarisModel extends Model
{
    // db name
    protected $DBGroup = 'sik';

    /** table name */
    protected $table = "inventaris_pembelian";

    /** primaryKey Field */
    protected $primaryKey = 'no_faktur';

    /** primaryKey autoincrement */
    //protected $useAutoIncrement = true;
    /** allowed Field */
    protected $allowedFields = ['no_faktur','kode_suplier','nip','tgl_beli','subtotal','potongan','total','ppn','meterai','tagihan','kd_rek','kd_rek_aset'];

    public function getData()
    {
        return $this->select('inventaris_pembelian.*, petugas.*')
        ->join('petugas','inventaris_pembelian.nip=petugas.nip')
        ->join('inventaris_suplier','inventaris_pembelian.kode_suplier=inventaris_suplier.kode_suplier')
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
