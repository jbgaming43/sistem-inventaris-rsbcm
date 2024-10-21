<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PengeluaranNonMedisModel;
use App\Models\PengeluaranNonMedisDetailModel;
use App\Models\PetugasModel;
use App\Models\IpsrsBarangModel;
use App\Helpers\AuthHelper;

class PengeluaranNonMedisController extends BaseController
{
    public function index()
    {
        // objek untuk data permintaan non medis dan pilihan input
        $pengeluaran_nonmedis_mod = new PengeluaranNonMedisModel();
        $petugas_mod = new PetugasModel();
        $ipsrsbarang_mod = new IpsrsBarangModel();

        $data = [
            'title' => 'Data Pengeluaran Non Medis',
            'active_menu' => 'non_medis',
            'active_submenu' => 'pengeluaran_non_medis',

            'pengeluaran_nonmedis_con' => $pengeluaran_nonmedis_mod->getData(),
            'petugas_con' => $petugas_mod->getData(),
            'ipsrsbarang_con' => $ipsrsbarang_mod->getData()
        ];

        return view('pengeluaran_nonmedis/index', $data);
    }

    public function add()
    {
        $dbSik = \Config\Database::connect('sik');

        // Inisialisasi model
        $pengeluaran_nonmedis_mod = new PengeluaranNonMedisModel();
        $pengeluaran_nonmedis_det_mod = new PengeluaranNonMedisDetailModel();
        $ipsrsbarang_mod = new IpsrsBarangModel();

        // Ambil data dari form
        $no_keluar = $this->request->getPost('no_keluar');

        // Cek apakah nomor pengeluaran sudah ada di database
        if ($pengeluaran_nonmedis_mod->where('no_keluar', $no_keluar)->first()) {
            return redirect()->back()->with('error', 'Nomor pengeluaran sudah ada, gunakan nomor pengeluaran yang berbeda.');
        }

        $tanggal = $this->request->getPost('tanggal');
        $nip = $this->request->getPost('nip');
        $keterangan = $this->request->getPost('keterangan');

        // Ambil data tabel barang yang diinputkan dalam bentuk array
        $kode_barang = $this->request->getPost('kode_brng'); // pastikan ini dikirim sebagai array
        $kode_sat = $this->request->getPost('kode_sat'); // pastikan ini dikirim sebagai array
        $jumlah = $this->request->getPost('jumlah'); // array
        $harga = $this->request->getPost('harga'); // array

        // Cek apakah semua input adalah array
        if (!is_array($kode_barang) || !is_array($jumlah) || !is_array($harga)) {
            return redirect()->back()->with('error', 'Data input tidak valid.');
        }

        $total = 0;

        // mulai transaksi
        $dbSik->transBegin();

        try {

            // Hitung total harga
            for ($i = 0; $i < count($kode_barang); $i++) {
                $total += $harga[$i] * $jumlah[$i];
            }

            // Persiapkan data untuk tabel pengeluaran_non_medis
            $dataPengeluaran = [
                'no_keluar' => $no_keluar,
                'tanggal' => $tanggal,
                'nip' => $nip,
                'keterangan' => $keterangan,
            ];

            // Simpan data pengeluaran ke tabel pengeluaran_non_medis
            $pengeluaran_nonmedis_mod->insertData($dataPengeluaran);

            // Ambil stok barang dari database dalam satu query
            $stok_barang = $ipsrsbarang_mod->getStokByKodeArray($kode_barang);

            // Convert hasil menjadi array yang mudah digunakan dengan key 'kode_barang'
            $stok_map = [];
            foreach ($stok_barang as $barang) {
                $stok_map[$barang['kode_brng']] = $barang['stok'];
            }

            // Proses data detail barang dan update stok dalam satu loop
            for ($index = 0; $index < count($kode_barang); $index++) {
                // Ambil stok lama dari $stok_map
                $stok_lama = isset($stok_map[$kode_barang[$index]]) ? $stok_map[$kode_barang[$index]] : 0;

                // Cek apakah stok cukup untuk pengeluaran
                // if ($stok_lama < $jumlah[$index]) {
                //     return redirect()->back()->with('error', 'Stok barang ' . $kode_barang[$index] . ' tidak mencukupi.');
                // }

                // Update stok dengan mengurangi jumlah barang yang dikeluarkan
                $stok_baru = $stok_lama - $jumlah[$index];
                if ($stok_baru >= 0) {
                    $ipsrsbarang_mod->updateStok($kode_barang[$index], $stok_baru);
                } else {
                    $dbSik->transRollback();
                    return redirect()->back()->with('error', 'Stok barang ' . $kode_barang[$index] . ' tidak mencukupi.');
                }

                // Simpan data detail pengeluaran ke tabel pengeluaran_non_medis_detail
                $dataDetail[] = [
                    'no_keluar' => $no_keluar,
                    'kode_brng' => $kode_barang[$index],
                    'kode_sat' => $kode_sat[$index],
                    'jumlah' => $jumlah[$index],
                    'harga' => $harga[$index],
                    'total' => $harga[$index] * $jumlah[$index],
                ];
            }

            $pengeluaran_nonmedis_det_mod->insertBatch($dataDetail);

            if ($dbSik->transStatus() === false) {
                $dbSik->transRollback();
                return redirect()->back()->with('error', 'Transaksi gagal.');
            } else {
                $dbSik->transCommit();
                return redirect()->to('/pengeluaran_non_medis')->with('success', 'Data berhasil disimpan.');
            }
        } catch (\Exception $e) {
            $dbSik->transRollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function detail($id)
    {
        $pengeluaran_nonmedis_det_mod = new PengeluaranNonMedisDetailModel();
        $detail = $pengeluaran_nonmedis_det_mod->detailData($id);

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
        return redirect()->to('/pengeluaran_non_medis');
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
        $pengeluaran_nonmedis_det_mod = new PengeluaranNonMedisDetailModel();

        $data = [
            'pengeluaran_nonmedis_con' => $pengeluaran_nonmedis_mod->getDataById($id),
            'pengeluaran_nonmedis_det_con' => $pengeluaran_nonmedis_det_mod->detailData($id),
        ];

        return view('pengeluaran_nonmedis/page_print', $data);
    }
}
