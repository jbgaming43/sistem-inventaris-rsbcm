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
        // objek PenggunaModel
        $pbnm = new PengajuanInventarisModel();
        $pgwm = new PegawaiModel();

        $data = [
            'title' => 'Data Pengajuan Inventaris',
            'active_menu' => 'inventaris',
            'active_submenu' => 'pengajuan_inventaris',

            'pbnc' => $pbnm->getData(),
            'pgwc' => $pgwm->getData(),
        ];


        return view('pengajuan_inventaris/index', $data);
    }

    public function add()
    {
        // objek PenggunaModel
        $pbnm = new PengajuanInventarisModel();

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

        $pbnm->insertData($data);

        session()->setFlashdata('success', 'ditambahkan');
        return redirect()->to('/pengajuan_inventaris');
    }

    public function edit($id)
    {
        $pbnm = new PengajuanInventarisModel();

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

        $pbnm->updateData($id, $data);

        session()->setFlashdata('success', 'diedit');
        return redirect()->to('/pengajuan_inventaris');
    }

    public function delete($id)
    {
        $pbnm = new PengajuanInventarisModel();

        $pbnm->deleteData($id);

        session()->setFlashdata('success', 'dihapus');
        return redirect()->to('/pengajuan_inventaris');
    }
}
