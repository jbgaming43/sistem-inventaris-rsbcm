<?php

namespace App\Controllers;

use App\Models\InventarisBarangModel;
use App\Models\InventarisModel;
use App\Models\RekeningModel;
use App\Models\RuangModel;
use App\Models\SuplierModel;
use CodeIgniter\Controller;
use App\Models\PenerimaanNonMedisModel;
use App\Models\PembelianNonMedisModel;
use App\Models\PembelianNonMedisDetailModel;
use App\Models\PenerimaanNonMedisDetailModel;
use App\Models\GaransiModel;
use App\Models\PetugasModel;
use App\Models\AkunBayarModel;
use App\Models\IpsrsBarangModel;
use App\Helpers\AuthHelper;

use App\Libraries\phpqrcode\qrlib;
use DateTime;

class PenerimaanNonMedisController extends BaseController
{
    public function index()
    {
        // objek PenggunaModel
        $penerimaan_nonmedis_mod = new PenerimaanNonMedisModel();
        $pembelian_nonmedis_mod = new PembelianNonMedisModel();
        $inv_mod = new InventarisModel();
        $ruang_mod = new RuangModel();

        $ptgm = new PetugasModel();
        $supm = new SuplierModel();
        $akbm = new AkunBayarModel();
        $rekm = new RekeningModel();
        $brgm = new InventarisBarangModel();

        $data = [
            'title' => 'Data Penerimaan Non Medis',
            'active_menu' => 'non_medis',
            'active_submenu' => 'penerimaan_non_medis',

            'penerimaan_nonmedis_con' => $penerimaan_nonmedis_mod->getData(),
            'pembelian_nonmedis_con' => $pembelian_nonmedis_mod->getData(),
            'ptgc' => $ptgm->getData(),
            'supc' => $supm->getData(),
            'akbc' => $akbm->getData(),
            'rekc' => $rekm->getData(),
            'brgc' => $brgm->getData(),
            'inv_con' => $inv_mod->getData(),
            'ruang_con' => $ruang_mod->getData(),
        ];


        return view('penerimaan_nonmedis/index', $data);
    }

    public function detail($id)
    {
        $pembelian_nonmedis_det_mod = new PembelianNonMedisDetailModel();
        $detail = $pembelian_nonmedis_det_mod->detailData($id);

        if ($detail) {
            // Kirim data dalam format JSON
            return $this->response->setJSON(['success' => true, 'detail' => $detail]);
        } else {
            return $this->response->setJSON(['success' => false]);
        }
    }

    public function add()
    {
        // ngedefine untuk transaction
        $dbSik = \Config\Database::connect('sik');

        // Inisialisasi model
        $penerimaan_nonmedis_mod = new PenerimaanNonMedisModel();
        $penerimaan_nonmedis_det_mod = new PenerimaanNonMedisDetailModel();
        $ipsrsbarang_mod = new IpsrsBarangModel();

        // Ambil data dari form
        $no_faktur = $this->request->getPost('no_faktur');

        // Cek apakah nomor faktur sudah ada di database
        if ($penerimaan_nonmedis_mod->where('no_faktur', $no_faktur)->first()) {
            return redirect()->back()->with('error', 'Nomor faktur sudah ada, gunakan nomor faktur yang berbeda.');
        }

        $no_order = $this->request->getPost('no_order');
        $kode_suplier = $this->request->getPost('kode_suplier');
        $nip = $this->request->getPost('nip');
        $tgl_pesan = $this->request->getPost('tgl_pesan');
        $tgl_faktur = $this->request->getPost('tgl_faktur');
        $tgl_tempo = $this->request->getPost('tgl_tempo');
        $kd_rek_aset = $this->request->getPost('kd_rek_aset');
        $ppn = $this->request->getPost('ppn');
        $meterai = $this->request->getPost('meterai');

        // Ambil data tabel barang yang diinputkan dalam bentuk array
        $kode_barang = $this->request->getPost('kode_barang'); // pastikan ini dikirim sebagai array
        $kode_sat = $this->request->getPost('kode_sat'); // pastikan ini dikirim sebagai array
        $jumlah = $this->request->getPost('jumlah'); // array
        $harga_beli = $this->request->getPost('harga_beli'); // array
        $diskon = $this->request->getPost('diskon'); // array
        $total = $this->request->getPost('total'); // array

        // Cek apakah semua input adalah array
        if (!is_array($kode_barang) || !is_array($jumlah) || !is_array($harga_beli) || !is_array($diskon) || !is_array($total)) {
            return redirect()->back()->with('error', 'Data input tidak valid.');
        }

        $totalBesardis = 0;
        $totalTotal = 0;
        // mulai transaksi
        $dbSik->transBegin();

        try {

            for ($i = 0; $i < count($kode_barang); $i++) {
                // hitung untuk data saat ini
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
                'no_order' => $no_order,
                'kode_suplier' => $kode_suplier,
                'nip' => $nip,
                'tgl_pesan' => $tgl_pesan,
                'tgl_faktur' => $tgl_faktur,
                'tgl_tempo' => $tgl_tempo,
                'total1' => $totalTotal,
                'potongan' => $totalBesardis,
                'total2' => $totalTotal - $totalBesardis,
                'ppn' => $ppn,
                'meterai' => $meterai,
                'tagihan' => $tagihan,
                'status' => 'Belum Dibayar',
            ];

            // Simpan data pembelian ke tabel inventaris_pembelian
            $penerimaan_nonmedis_mod->insertData($dataPembelian);

            // Ambil stok barang dari database dalam satu query
            $stok_barang = $ipsrsbarang_mod->getStokByKodeArray($kode_barang);

            // Convert hasil menjadi array yang mudah digunakan dengan key 'kode_barang'
            $stok_map = [];
            foreach ($stok_barang as $barang) {
                $stok_map[$barang['kode_brng']] = $barang['stok'];
            }

            // Proses data detail barang
            for ($index = 0; $index < count($kode_barang); $index++) {
                // Ambil stok lama dari $stok_map
                $stok_lama = isset($stok_map[$kode_barang[$index]]) ? $stok_map[$kode_barang[$index]] : 0;

                // Update stok dengan menambahkan jumlah barang yang diterima
                $stok_baru = $stok_lama + $jumlah[$index];
                $ipsrsbarang_mod->updateStok($kode_barang[$index], $stok_baru);

                // Ambil nilai jumlah dari setiap item
                $jumlahBarang = $jumlah[$index];

                // Hitung subtotal, potongan, dan total
                $subtotal = $harga_beli[$index] * $jumlahBarang;
                $besardis = ($harga_beli[$index] * $jumlahBarang) * ($diskon[$index] / 100);
                $total = $subtotal - $besardis;

                // Simpan data detail pembelian ke tabel inventaris_detail_beli
                $dataDetail[] = [
                    'no_faktur' => $no_faktur,
                    'kode_brng' => $kode_barang[$index],
                    'kode_sat' => $kode_sat[$index],
                    'jumlah' => $jumlah[$index],
                    'harga' => $harga_beli[$index],
                    'subtotal' => $subtotal,
                    'dis' => $diskon[$index],
                    'besardis' => $besardis,
                    'total' => $total
                ];
            }

            $penerimaan_nonmedis_det_mod->insertBatch($dataDetail);

            if ($dbSik->transStatus() === false) {
                $dbSik->transRollback();
                return redirect()->back()->with('error', 'Transaksi gagal.');
            } else {
                $dbSik->transCommit();
                return redirect()->to('/penerimaan_non_medis')->with('success', 'Data berhasil disimpan.');
            }
        } catch (\Exception $e) {
            $dbSik->transRollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function delete($id)
    {
        $penerimaan_nonmedis_mod = new PenerimaanNonMedisModel();

        $penerimaan_nonmedis_mod->deleteData($id);

        session()->setFlashdata('success', 'dihapus');
        return redirect()->to('/penerimaan_non_medis');
    }

    public function print($id)
    {
        $penerimaan_nonmedis_mod = new PenerimaanNonMedisModel();
        $penerimaan_nonmedis_det_mod = new PenerimaanNonMedisDetailModel();

        $data = [
            'penerimaan_nonmedis_con' => $penerimaan_nonmedis_mod->getDataById($id),
            'penerimaan_nonmedis_det_con' => $penerimaan_nonmedis_det_mod->detailData($id),
        ];

        return view('penerimaan_nonmedis/page_print', $data);
    }

    public function getFaktur()
    {
        $pembelian_nonmedis_mod = new PembelianNonMedisModel();
        $no_faktur = $this->request->getGet('no_faktur');
        if ($no_faktur) {
            $faktur = $pembelian_nonmedis_mod->getDataById($no_faktur);
            if ($faktur) {
                return $this->response->setJSON($faktur);
            }
        }
        return $this->response->setJSON(null);
    }

    public function info($id)
    {
        $inv_mod = new InventarisModel();
        $id_s = 'INV/2023/12/14/001';
        $tes = base_url('penerimaan_nonmedis/info/') . $id;

        $data = [
            'inv_con' => $inv_mod->getDataById($id),
        ];

        return view('penerimaan_nonmedis/page_info', $data);
    }
}
