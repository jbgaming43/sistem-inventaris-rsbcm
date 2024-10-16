<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PermintaanNonMedisModel;
use App\Models\PermintaanNonMedisDetailModel;
use App\Models\PegawaiModel;
use App\Models\IpsrsBarangModel;
use App\Helpers\AuthHelper;

class PermintaanNonMedisController extends BaseController
{
    public function index()
    {
        // objek untuk data permintaan non medis dan pilihan input
        $permintaan_nonmedis_mod = new PermintaanNonMedisModel();
        $pegawai_mod = new PegawaiModel();
        $ipsrsbarang_mod = new IpsrsBarangModel();

        $data = [
            'title' => 'Data Permintaan Non Medis',
            'active_menu' => 'non_medis',
            'active_submenu' => 'permintaan_nonmedis',

            'per_barang_nonmedis_con' => $permintaan_nonmedis_mod->getData(),
            'pgwc' => $pegawai_mod->getData(),
            'ipsrsbarang_con' => $ipsrsbarang_mod->getData()
        ];

        return view('permintaan_nonmedis/index', $data);
    }

    public function add()
    {
        // objek PenggunaModel
        $permintaan_nonmedis_mod = new PermintaanNonMedisModel();
        $permintaan_nonmedis_det_mod = new PermintaanNonMedisDetailModel();

        $no_pengajuan = $this->request->getPost('no_pengajuan');
        $tanggal = $this->request->getPost('tanggal');
        $nik = $this->request->getPost('nik');
        $keterangan = $this->request->getPost('keterangan');

        // Ambil data tabel barang yang diinputkan dalam bentuk array
        $kode_brng = $this->request->getPost('kode_brng');
        $kode_sat = $this->request->getPost('kode_sat');
        $jumlah = $this->request->getPost('jumlah');
        $h_pengajuan = $this->request->getPost('harga');

        // Cek apakah semua input adalah array
        if (!is_array($kode_brng) || !is_array($kode_sat) || !is_array($jumlah) || !is_array($h_pengajuan)) {
            return redirect()->back()->with('error', 'Data input tidak valid.');
        }

        // Cek apakah panjang semua array sama
        $arrayCount = min(count($kode_brng), count($kode_sat), count($jumlah), count($h_pengajuan));
        if ($arrayCount === 0) {
            return redirect()->back()->with('error', 'Tidak ada data yang valid untuk disimpan.');
        }

        $data = [
            'no_pengajuan' => $no_pengajuan,
            'nip' => $nik,
            'tanggal' => $tanggal,
            'status' => 'Proses Pengajuan',
            'keterangan' => $keterangan,
        ];

        $permintaan_nonmedis_mod->insertData($data);
        $dataDetails = [];

        for ($i = 0; $i < count($kode_brng); $i++) {
            $dataDetails[] = [
                'no_pengajuan' => $no_pengajuan,
                'kode_brng' => $kode_brng[$i],
                'kode_sat' => $kode_sat[$i],
                'jumlah' => $jumlah[$i],
                'h_pengajuan' => $h_pengajuan[$i],
                'total' => $jumlah[$i] * $h_pengajuan[$i],
            ];
        }

        // Insert semua data secara batch
        $permintaan_nonmedis_det_mod->insertBatch($dataDetails);

        session()->setFlashdata('success', 'ditambahkan');
        return redirect()->to('/pengajuan_non_medis');
    }

    public function detail($id)
    {
        $permintaan_nonmedis_det_mod = new PermintaanNonMedisDetailModel();
        $detail = $permintaan_nonmedis_det_mod->detailData($id);

        // Debug output
        log_message('debug', 'Detail fetched: ' . json_encode($detail)); // Log detail untuk debug

        if (empty($detail)) {
            return $this->response->setJSON(['error' => 'Data tidak ditemukan']);
        }

        return $this->response->setJSON($detail);
    }

    public function delete($id)
    {
        $permintaan_nonmedis_mod = new PermintaanNonMedisModel();

        $permintaan_nonmedis_mod->deleteData($id);

        session()->setFlashdata('success', 'dihapus');
        return redirect()->to('/pengajuan_non_medis');
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

    public function setuju($id)
    {
        $permintaan_nonmedis_mod = new PermintaanNonMedisModel();

        $data = [
            'status' => 'Disetujui'
        ];

        $permintaan_nonmedis_mod->updateData($id, $data);

        session()->setFlashdata('success', 'disetujui');
        return redirect()->to('/pengajuan_non_medis');
    }

    public function tolak($id)
    {
        $permintaan_nonmedis_mod = new PermintaanNonMedisModel();

        $data = [
            'status' => 'Ditolak'
        ];

        $permintaan_nonmedis_mod->updateData($id, $data);

        session()->setFlashdata('success', 'ditolak');
        return redirect()->to('/pengajuan_non_medis');
    }

    public function print($id)
    {
        $permintaan_nonmedis_mod = new PermintaanNonMedisModel();
        $permintaan_nonmedis_det_mod = new PermintaanNonMedisDetailModel();

        $data = [
            'pen_nonmedis_con' => $permintaan_nonmedis_mod->getDataById($id),
            'pen_nonmedis_det_con' => $permintaan_nonmedis_det_mod->detailData($id),
        ];

        return view('pengajuan_nonmedis/page_print', $data);
    }
}
