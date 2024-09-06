<?php

namespace App\Controllers;

use App\Models\InventarisBarangModel;
use App\Models\RekeningModel;
use App\Models\SuplierModel;
use CodeIgniter\Controller;
use App\Models\PembelianInventarisModel;
use App\Models\PetugasModel;
use App\Models\AkunBayarModel;
use App\Helpers\AuthHelper;

class PembelianInventarisController extends BaseController
{
    public function index()
    {
        // objek PenggunaModel
        $pbnm = new PembelianInventarisModel();
        $ptgm = new PetugasModel();
        $supm = new SuplierModel();
        $akbm = new AkunBayarModel();
        $rekm = new RekeningModel();
        $brgm = new InventarisBarangModel();

        $data = [
            'title' => 'Data Pembelian Inventaris',
            'active_menu' => 'inventaris',
            'active_submenu' => 'pembelian_inventaris',

            'pbnc' => $pbnm->getData(),
            'ptgc' => $ptgm->getData(),
            'supc' => $supm->getData(),
            'akbc' => $akbm->getData(),
            'rekc' => $rekm->getData(),
            'brgc' => $brgm->getData(),
        ];


        return view('pembelian_inventaris/index', $data);
    }

    public function add()
    {
        // objek PenggunaModel
        $pbnm = new PembelianInventarisModel();

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
        $pbnm = new PembelianInventarisModel();

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
        $pbnm = new PembelianInventarisModel();

        $pbnm->deleteData($id);

        session()->setFlashdata('success', 'dihapus');
        return redirect()->to('/pengajuan_inventaris');
    }

    public function setuju($id)
    {
        $pbnm = new PembelianInventarisModel();

        $data = [
            'status' => 'Disetujui'
        ];

        $pbnm->updateData($id, $data);

        session()->setFlashdata('success', 'disetujui');
        return redirect()->to('/pengajuan_inventaris');
    }

    public function tolak($id)
    {
        $pbnm = new PembelianInventarisModel();

        $data = [
            'status' => 'Ditolak'
        ];

        $pbnm->updateData($id, $data);

        session()->setFlashdata('success', 'ditolak');
        return redirect()->to('/pengajuan_inventaris');
    }

    public function print()
    {
        $pbnm = new PembelianInventarisModel();

        $tanggal_awal = $this->request->getPost('tanggal_awal');
        $tanggal_akhir = $this->request->getPost('tanggal_akhir');
        $nik = $this->request->getPost('nik');

        $data = $pbnm->printData($tanggal_awal, $tanggal_akhir, $nik);
        // var_dump($data);

        return view('pengajuan_inventaris/page_print', ['data' => $data, 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir, 'nik' => $nik]);
    }

    public function getBarangDetails()
    {
        $brgm = new InventarisBarangModel();
        $kode_barang = $this->request->getGet('kode_barang');
        if ($kode_barang) {
            $barang = $brgm->getDataByKode($kode_barang);
            if ($barang) {
                return $this->response->setJSON($barang);
            }
        }
        return $this->response->setJSON(null);
    }
}
