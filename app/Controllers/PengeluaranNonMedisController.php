<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PengeluaranNonMedisModel;
use App\Models\PengeluaranNonMedisDetailModel;
use App\Models\PegawaiModel;
use App\Models\IpsrsBarangModel;
use App\Helpers\AuthHelper;

class PengeluaranNonMedisController extends BaseController
{
    public function index()
    {
        // objek untuk data permintaan non medis dan pilihan input
        $pengeluaran_nonmedis_mod = new PengeluaranNonMedisModel();
        $pegawai_mod = new PegawaiModel();
        $ipsrsbarang_mod = new IpsrsBarangModel();

        $data = [
            'title' => 'Data Pengeluaran Non Medis',
            'active_menu' => 'non_medis',
            'active_submenu' => 'pengeluaran_non_medis',

            'pengeluaran_nonmedis_con' => $pengeluaran_nonmedis_mod->getData(),
            'pgwc' => $pegawai_mod->getData(),
            'ipsrsbarang_con' => $ipsrsbarang_mod->getData()
        ];

        return view('pengeluaran_nonmedis/index', $data);
    }

    public function add()
    {
        // objek PenggunaModel
        $pengeluaran_nonmedis_mod = new PengeluaranNonMedisModel();
        $permintaan_nonmedis_det_mod = new PengeluaranNonMedisDetailModel();

        $no_permintaan = $this->request->getPost('no_permintaan');

        $duplicate = $pengeluaran_nonmedis_mod->getDataById($no_permintaan);
        if ($duplicate) {
            session()->setFlashdata('error', 'Nomor Permintaan Sudah Ada');
            return redirect()->to('/permintaan_non_medis');
        }


        $ruang = $this->request->getPost('ruang');
        $tanggal = $this->request->getPost('tanggal');
        $nik = $this->request->getPost('nik');
        $keterangan = $this->request->getPost('keterangan');

        // Ambil data tabel barang yang diinputkan dalam bentuk array
        $kode_brng = $this->request->getPost('kode_brng');
        $kode_sat = $this->request->getPost('kode_sat');
        $jumlah = $this->request->getPost('jumlah');
        $keterangan = $this->request->getPost('keterangan');

        // Cek apakah semua input adalah array
        if (!is_array($kode_brng) || !is_array($kode_sat) || !is_array($jumlah)) {
            return redirect()->back()->with('error', 'Data input tidak valid.');
        }

        // Cek apakah panjang semua array sama
        $arrayCount = min(count($kode_brng), count($kode_sat), count($jumlah));
        if ($arrayCount === 0) {
            return redirect()->back()->with('error', 'Tidak ada data yang valid untuk disimpan.');
        }

        $data = [
            'no_permintaan' => $no_permintaan,
            'ruang' => $ruang,
            'nip' => $nik,
            'tanggal' => $tanggal,
            'status' => 'Baru',
        ];

        $pengeluaran_nonmedis_mod->insertData($data);
        $dataDetails = [];

        for ($i = 0; $i < count($kode_brng); $i++) {
            $dataDetails[] = [
                'no_permintaan' => $no_permintaan,
                'kode_brng' => $kode_brng[$i],
                'kode_sat' => $kode_sat[$i],
                'jumlah' => $jumlah[$i],
                'keterangan' => $keterangan[$i],
            ];
        }

        // Insert semua data secara batch
        $permintaan_nonmedis_det_mod->insertBatch($dataDetails);

        session()->setFlashdata('success', 'ditambahkan');
        return redirect()->to('/permintaan_non_medis');
    }

    public function detail($id)
    {
        $permintaan_nonmedis_det_mod = new PengeluaranNonMedisDetailModel();
        $detail = $permintaan_nonmedis_det_mod->detailData($id);

        if ($detail) {
            // Kirim data dalam format JSON
            return $this->response->setJSON(['success' => true, 'detail' => $detail]);
        } else {
            return $this->response->setJSON(['success' => false]);
        }
    }

    public function delete($id)
    {
        $pengeluaran_nonmedis_mod = new PengeluaranNonMedisModel();

        $pengeluaran_nonmedis_mod->deleteData($id);

        session()->setFlashdata('success', 'dihapus');
        return redirect()->to('/permintaan_non_medis');
    }

    public function getBarangDetails()
    {
        $ipsrsbarang_mod = new IpsrsBarangModel();
        $kode_barang = $this->request->getGet('kode_brng'); // Mengambil kode barang dari parameter GET

        if ($kode_barang) {
            $barang = $ipsrsbarang_mod->getDataByKode($kode_barang);
            if ($barang) {
                return $this->response->setJSON($barang);
            }
        }

        return $this->response->setJSON(null); // Kembalikan JSON null jika barang tidak ditemukan
    }

    public function print($id)
    {
        $pengeluaran_nonmedis_mod = new PengeluaranNonMedisModel();
        $permintaan_nonmedis_det_mod = new PengeluaranNonMedisDetailModel();

        $data = [
            'permintaan_nonmedis_con' => $pengeluaran_nonmedis_mod->getDataById($id),
            'permintaan_nonmedis_det_con' => $permintaan_nonmedis_det_mod->detailData($id),
        ];
        // $t = $permintaan_nonmedis_det_mod->detailData($id);
        // dd($t);

        return view('permintaan_nonmedis/page_print', $data);
    }
}
