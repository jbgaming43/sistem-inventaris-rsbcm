<?php

namespace App\Controllers;

use App\Models\InventarisBarangModel;
use App\Models\RekeningModel;
use App\Models\SuplierModel;
use CodeIgniter\Controller;
use App\Models\PembelianInventarisModel;
use App\Models\PembelianInventarisDetailModel;
use App\Models\PetugasModel;
use App\Models\AkunBayarModel;
use App\Helpers\AuthHelper;

class PembelianInventarisController extends BaseController
{
    public function index()
    {
        // objek PenggunaModel
        $pem_inv_mod = new PembelianInventarisModel();
        $ptgm = new PetugasModel();
        $supm = new SuplierModel();
        $akbm = new AkunBayarModel();
        $rekm = new RekeningModel();
        $brgm = new InventarisBarangModel();

        $data = [
            'title' => 'Data Pembelian Inventaris',
            'active_menu' => 'inventaris',
            'active_submenu' => 'pembelian_inventaris',

            'pem_inv_con' => $pem_inv_mod->getData(),
            'ptgc' => $ptgm->getData(),
            'supc' => $supm->getData(),
            'akbc' => $akbm->getData(),
            'rekc' => $rekm->getData(),
            'brgc' => $brgm->getData(),
        ];


        return view('pembelian_inventaris/index', $data);
    }

    public function detail($no_faktur) 
    {
        $pem_inv_det_mod = new PembelianInventarisDetailModel();
        $detail = $pem_inv_det_mod->where('no_faktur', $no_faktur)->findAll();

        return $this->response->setJSON($detail);
    }

    public function add()
    {
        // Inisialisasi model
        $pem_inv_mod = new PembelianInventarisModel();
        $pem_inv_det_mod = new PembelianInventarisDetailModel();

        // Ambil data dari form
        $no_faktur = $this->request->getPost('no_faktur');

        // Cek apakah nomor faktur sudah ada di database
        if ($pem_inv_mod->where('no_faktur', $no_faktur)->first()) {
            return redirect()->back()->with('error', 'Nomor faktur sudah ada, gunakan nomor faktur yang berbeda.');
        }

        $kode_suplier = $this->request->getPost('kode_suplier');
        $nip = $this->request->getPost('nip');
        $tgl_beli = $this->request->getPost('tgl_beli');
        $kd_rek = $this->request->getPost('kd_rek');
        $kd_rek_aset = $this->request->getPost('kd_rek_aset');
        $ppn = $this->request->getPost('ppn');
        $meterai = $this->request->getPost('meterai');

        // Ambil data tabel barang yang diinputkan dalam bentuk array
        $kode_barang = $this->request->getPost('kode_barang'); // pastikan ini dikirim sebagai array
        $jumlah = $this->request->getPost('jumlah'); // array
        $harga_beli = $this->request->getPost('harga_beli'); // array
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
        $pem_inv_mod->insertData($dataPembelian);

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
        return redirect()->to('/pembelian_inventaris')->with('success', 'Data pembelian berhasil disimpan.');
    }



    public function edit($id)
    {
        $pbnm = new PembelianInventarisModel();


        session()->setFlashdata('success', 'diedit');
        return redirect()->to('/pengajuan_inventaris');
    }

    public function delete($id)
    {
        $pem_inv_mod = new PembelianInventarisModel();

        $pem_inv_mod->deleteData($id);

        session()->setFlashdata('success', 'dihapus');
        return redirect()->to('/pembelian_inventaris');
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
