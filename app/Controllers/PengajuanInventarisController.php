<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PengajuanInventarisModel;
use App\Models\PegawaiModel;
use App\Helpers\AuthHelper;

class PengajuanInventarisController extends BaseController
{
    public function index()
    {
        // inisiasi objek
        $pengajuan_inv_mod = new PengajuanInventarisModel();
        $pegawai_mod = new PegawaiModel();

        $data = [
            'title' => 'Data Pengajuan Inventaris',
            'active_menu' => 'inventaris',
            'active_submenu' => 'pengajuan_inventaris',

            'pengajuan_inv_con' => $pengajuan_inv_mod->getData(),
            'pegawai_con' => $pegawai_mod->getData(),
        ];


        return view('pengajuan_inventaris/index', $data);
    }

    public function add()
    {
        // inisiasi objek
        $pengajuan_inv_mod = new PengajuanInventarisModel();

        $jumlah = $this->request->getPost('jumlah');
        $harga = $this->request->getPost('harga');
        $total = $jumlah * $harga;

        $data = [
            'no_pengajuan' => $this->request->getPost('no_pengajuan'),
            'tanggal' => $this->request->getPost('tanggal'),
            'nik' => $this->request->getPost('nik'),
            'urgensi' => $this->request->getPost('urgensi'),
            'latar_belakang' => $this->request->getPost('latar_belakang'),
            'nama_barang' => $this->request->getPost('nama_barang'),
            'spesifikasi' => $this->request->getPost('spesifikasi'),
            'jumlah' => $this->request->getPost('jumlah'),
            'harga' => $this->request->getPost('harga'),
            'total' => $total,
            'keterangan' => $this->request->getPost('keterangan'),
            'nik_pj' => $this->request->getPost('nik_pj'),
            'status' => 'Proses Pengajuan'
        ];

        $pengajuan_inv_mod->insertData($data);

        session()->setFlashdata('success', 'ditambahkan');
        return redirect()->to('/pengajuan_inventaris');
    }

    public function edit($id)
    {
        $pengajuan_inv_mod = new PengajuanInventarisModel();

        $jumlah = $this->request->getPost('jumlah');
        $harga = $this->request->getPost('harga');
        $total = $jumlah * $harga;

        $data = [
            'no_pengajuan' => $this->request->getPost('no_pengajuan_new'),
            'tanggal' => $this->request->getPost('tanggal'),
            'nik' => $this->request->getPost('nik'),
            'urgensi' => $this->request->getPost('urgensi'),
            'latar_belakang' => $this->request->getPost('latar_belakang'),
            'nama_barang' => $this->request->getPost('nama_barang'),
            'spesifikasi' => $this->request->getPost('spesifikasi'),
            'jumlah' => $this->request->getPost('jumlah'),
            'harga' => $this->request->getPost('harga'),
            'total' => $total,
            'keterangan' => $this->request->getPost('keterangan'),
            'nik_pj' => $this->request->getPost('nik_pj'),
            'status' => 'Proses Pengajuan'
        ];

        $pengajuan_inv_mod->updateData($id, $data);

        session()->setFlashdata('success', 'diedit');
        return redirect()->to('/pengajuan_inventaris');
    }

    public function delete($id)
    {
        $pengajuan_inv_mod = new PengajuanInventarisModel();

        $pengajuan_inv_mod->deleteData($id);

        session()->setFlashdata('success', 'dihapus');
        return redirect()->to('/pengajuan_inventaris');
    }

    public function setuju($id)
    {
        $pengajuan_inv_mod = new PengajuanInventarisModel();

        $data = [
            'status' => 'Disetujui'
        ];

        $pengajuan_inv_mod->updateData($id, $data);

        session()->setFlashdata('success', 'disetujui');
        return redirect()->to('/pengajuan_inventaris');
    }

    public function tolak($id)
    {
        $pengajuan_inv_mod = new PengajuanInventarisModel();

        $data = [
            'status' => 'Ditolak'
        ];

        $pengajuan_inv_mod->updateData($id, $data);

        session()->setFlashdata('success', 'ditolak');
        return redirect()->to('/pengajuan_inventaris');
    }

    public function print()
    {
        $pengajuan_inv_mod = new PengajuanInventarisModel();

        $tanggal_awal = $this->request->getPost('tanggal_awal');
        $tanggal_akhir = $this->request->getPost('tanggal_akhir');
        $nik = $this->request->getPost('nik');

        $data = $pengajuan_inv_mod->printData($tanggal_awal, $tanggal_akhir, $nik);
        // var_dump($data);

        return view('pengajuan_inventaris/page_print', ['data' => $data, 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir, 'nik' => $nik]);
    }
}
