<?php

namespace App\Controllers;

use App\Models\InventarisBarangModel;
use App\Models\RekeningModel;
use App\Models\IpsrsSuplierModel;
use CodeIgniter\Controller;
use App\Models\PembelianNonMedisModel;
use App\Models\PembelianNonMedisDetailModel;
use App\Models\PetugasModel;
use App\Models\AkunBayarModel;
use App\Helpers\AuthHelper;
use App\Models\IpsrsBarangModel;

class PembelianNonmedisController extends BaseController
{
    public function index()
    {
        // objek PenggunaModel
        $pem_nonmedis_mod = new PembelianNonMedisModel();
        $ipsrs_barang_mod = new IpsrsBarangModel();
        $ptgm = new PetugasModel();
        $ipsrs_sup_mod = new IpsrsSuplierModel();
        $akbm = new AkunBayarModel();

        $data = [
            'title' => 'Data Pembelian NonMedis',
            'active_menu' => 'non_medis',
            'active_submenu' => 'pembelian_nonmedis',

            'pem_nonmedis_con' => $pem_nonmedis_mod->getData(),
            'ipsrs_barang_con' => $ipsrs_barang_mod->getData(),
            'ptgc' => $ptgm->getData(),
            'ipsrs_sup_con' => $ipsrs_sup_mod->getData(),
            'akbc' => $akbm->getData(),
        ];

        return view('pembelian_nonmedis/index', $data);
    }

    public function detail($no_faktur)
    {
        $pem_inv_det_mod = new PembelianNonMedisDetailModel();
        $detail = $pem_inv_det_mod->detailData($no_faktur);

        return $this->response->setJSON($detail);
    }

    public function add()
    {
        // Inisialisasi model
        $pem_nonmedis_mod = new PembelianNonMedisModel();
        $pem_nonmedis_det_mod = new PembelianNonMedisDetailModel();

        // Ambil data dari form
        $no_faktur =  str_replace(' ', '', $this->request->getPost('no_faktur'));

        // Cek apakah nomor faktur sudah ada di database
        if ($pem_nonmedis_mod->where('no_faktur', $no_faktur)->first()) {
            return redirect()->back()->with('error', 'Nomor faktur sudah ada, gunakan nomor faktur yang berbeda.');
        }

        $kode_suplier = $this->request->getPost('kode_suplier');
        $nip = $this->request->getPost('nip');
        $tgl_beli = $this->request->getPost('tgl_beli');
        $kd_rek = $this->request->getPost('kd_rek');
        $ppn = $this->request->getPost('ppn');
        $meterai = $this->request->getPost('meterai');

        // Ambil data tabel barang yang diinputkan dalam bentuk array
        $kode_barang = $this->request->getPost('kode_brng'); // pastikan ini dikirim sebagai array
        $kode_sat = $this->request->getPost('kode_sat');
        $jumlah = $this->request->getPost('jumlah'); // array
        $harga_beli = $this->request->getPost('harga'); // array
        $diskon = $this->request->getPost('diskon'); // array
        $total = $this->request->getPost('total'); // array

        // Cek apakah semua input adalah array
        if (!is_array($kode_barang) || !is_array($jumlah) || !is_array($harga_beli) || !is_array($diskon) || !is_array($total)) {
            return redirect()->back()->with('error', 'Data input tidak valid.');
        }

        // Cek apakah panjang semua array sama
        $arrayCount = min(count($kode_barang), count($jumlah), count($harga_beli), count($diskon), count($total));
        if ($arrayCount === 0) {
            return redirect()->back()->with('error', 'Tidak ada data yang valid untuk disimpan.');
        }

        $totalBesardis = 0;
        $totalTotal = 0;

        for ($i = 0; $i < count($kode_barang); $i++) {
            //hitung utk data saat ini
            $subtotal = $harga_beli[$i] * $jumlah[$i];
            $besardis = ($harga_beli[$i] * $jumlah[$i]) * ($diskon[$i] / 100);
            $total = $subtotal - $besardis;

            $totalBesardis += $besardis;
            $totalTotal += $total;
        }

        $tagihan = ($totalTotal - $totalBesardis) + (($totalTotal - $totalBesardis) * ($ppn / 100)) + $meterai;

        // Persiapkan data untuk tabel inventaris_pembelian
        $dataPembelian = [
            'no_faktur' => $no_faktur,
            'kode_suplier' => $kode_suplier,
            'nip' => $nip,
            'tgl_beli' => $tgl_beli,
            'subtotal' => $totalTotal,
            'potongan' => $totalBesardis,
            'total' => $totalTotal - $totalBesardis,
            'ppn' => $ppn,
            'meterai' => $meterai,
            'tagihan' => $tagihan,
            'kd_rek' => $kd_rek,

            // hitung subtotal, potongan, dll. jika diperlukan
        ];

        // Simpan data pembelian ke tabel nonmedis_pembelian
        $pem_nonmedis_mod->insertData($dataPembelian);
        $dataDetail = [];
        // Loop melalui setiap barang yang diinputkan
        for ($i = 0; $i < count($kode_barang); $i++) {
            //hitung utk data saat ini
            $subtotal = $harga_beli[$i] * $jumlah[$i];
            $besardis = ($harga_beli[$i] * $jumlah[$i]) * ($diskon[$i] / 100);
            $total = $subtotal - $besardis;
            // Persiapkan data untuk tabel  nonmedis_detail_beli
            $dataDetail[] = [
                'no_faktur' => $no_faktur,
                'kode_brng' => $kode_barang[$i],
                'kode_sat' => $kode_sat[$i],
                'jumlah' => $jumlah[$i],
                'harga' => $harga_beli[$i],
                'subtotal' => $subtotal,
                'dis' => $diskon[$i],
                'besardis' => $besardis,
                'total' => $total
            ];

            // Simpan data detail pembelian ke tabel nonmedis_detail_beli

        }
        $pem_nonmedis_det_mod->insertData($dataDetail);

        // Redirect atau tampilkan pesan sukses
        return redirect()->to('/pembelian_non_medis')->with('success', 'Data pembelian berhasil disimpan.');
    }

    public function edit($id)
    {
        // Inisialisasi model
        $pem_inv_mod = new PembelianInventarisModel();
        $pem_inv_det_mod = new PembelianInventarisDetailModel();

        // Ambil data dari form
        $no_faktur = $this->request->getPost('no_faktur_new');

        if ($id != $no_faktur) {
            // Cek apakah nomor faktur sudah ada di database
            if ($pem_inv_mod->where('no_faktur', $no_faktur)->first()) {
                return redirect()->back()->with('error', 'Nomor faktur sudah ada, gunakan nomor faktur yang berbeda.');
            }
        }

        $kode_suplier = $this->request->getPost('kode_suplier');
        $nip = $this->request->getPost('nip');
        $tgl_beli = $this->request->getPost('tgl_beli');
        $kd_rek = $this->request->getPost('kd_rek');
        $kd_rek_aset = $this->request->getPost('kd_rek_aset');
        $ppn = $this->request->getPost('ppn');
        $meterai = $this->request->getPost('meterai');

        // Ambil data tabel barang yang diinputkan dalam bentuk array
        $kode_barang = $this->request->getPost('kode_brng'); // pastikan ini dikirim sebagai array
        $kode_barang = $this->request->getPost('kode_sat');
        $jumlah = $this->request->getPost('jumlah'); // array
        $harga_beli = $this->request->getPost('harga'); // array
        $diskon = $this->request->getPost('diskon'); // array
        $total = $this->request->getPost('total'); // array

        // Cek apakah semua input adalah array
        if (!is_array($kode_barang) || !is_array($jumlah) || !is_array($harga_beli) || !is_array($diskon) || !is_array($total)) {
            return redirect()->back()->with('error', 'Data input tidak valid.');
        }

        // Cek apakah panjang semua array sama
        $arrayCount = min(count($kode_barang), count($jumlah), count($harga_beli), count($diskon), count($total));
        if ($arrayCount === 0) {
            return redirect()->back()->with('error', 'Tidak ada data yang valid untuk disimpan.');
        }

        $totalBesardis = 0;
        $totalTotal = 0;

        for ($i = 0; $i < count($kode_barang); $i++) {
            //hitung utk data saat ini
            $subtotal = $harga_beli[$i] * $jumlah[$i];
            $besardis = ($harga_beli[$i] * $jumlah[$i]) * ($diskon[$i] / 100);
            $total = $subtotal - $besardis;

            $totalBesardis += $besardis;
            $totalTotal += $total;
        }

        $tagihan = ($totalTotal - $totalBesardis) + (($totalTotal - $totalBesardis) * ($ppn / 100)) + $meterai;

        // Persiapkan data untuk tabel inventaris_pembelian
        $dataPembelian = [
            'no_faktur' => $no_faktur,
            'kode_suplier' => $kode_suplier,
            'nip' => $nip,
            'tgl_beli' => $tgl_beli,
            'subtotal' => $totalTotal,
            'potongan' => $totalBesardis,
            'total' => $totalTotal - $totalBesardis,
            'ppn' => $ppn,
            'meterai' => $meterai,
            'tagihan' => $tagihan,
            'kd_rek' => $kd_rek,
            'kd_rek_aset' => $kd_rek_aset,

            // hitung subtotal, potongan, dll. jika diperlukan
        ];

        // Simpan data pembelian ke tabel inventaris_pembelian
        $pem_inv_mod->updateData($id, $dataPembelian);

        //hapus detail pembelian
        $pem_inv_det_mod->deleteDataByNoFaktur($no_faktur);

        // Loop melalui setiap barang yang diinputkan
        for ($i = 0; $i < count($kode_barang); $i++) {
            //hitung utk data saat ini
            $subtotal = $harga_beli[$i] * $jumlah[$i];
            $besardis = ($harga_beli[$i] * $jumlah[$i]) * ($diskon[$i] / 100);
            $total = $subtotal - $besardis;
            // Persiapkan data untuk tabel inventaris_detail_beli
            $dataDetail = [
                'no_faktur' => $no_faktur,
                'kode_barang' => $kode_barang[$i],
                'jumlah' => $jumlah[$i],
                'harga' => $harga_beli[$i],
                'subtotal' => $subtotal,
                'dis' => $diskon[$i],
                'besardis' => $besardis,
                'total' => $total
            ];

            // Simpan data detail pembelian ke tabel inventaris_detail_beli
            $pem_inv_det_mod->insert($dataDetail);
        }

        // Redirect atau tampilkan pesan sukses
        return redirect()->to('/pembelian_inventaris')->with('success', 'Data pembelian berhasil diedit.');
    }

    public function delete($id)
    {
        $pem_nonmedis_mod = new PembelianNonMedisModel();

        $pem_nonmedis_mod->deleteData($id);

        session()->setFlashdata('success', 'dihapus');
        return redirect()->to('/pembelian_non_medis');
    }

    public function print($id)
    {
        $pem_nonmedis_mod = new PembelianNonMedisModel();
        $pem_nonmedis_det_mod = new PembelianNonMedisDetailModel();

        $data = [
            'pem_nonmedis_con' => $pem_nonmedis_mod->getDataById($id),
            'pem_nonmedis_det_con' => $pem_nonmedis_det_mod->detailData($id),
        ];

        return view('pembelian_non_medis/page_print', $data);
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
