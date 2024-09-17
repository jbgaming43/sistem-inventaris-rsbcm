<?php

namespace App\Controllers;

use App\Models\InventarisBarangModel;
use App\Models\InventarisModel;
use App\Models\RekeningModel;
use App\Models\SuplierModel;
use CodeIgniter\Controller;
use App\Models\PenerimaanInventarisModel;
use App\Models\PembelianInventarisModel;
use App\Models\PembelianInventarisDetailModel;
use App\Models\PenerimaanInventarisDetailModel;
use App\Models\PetugasModel;
use App\Models\AkunBayarModel;
use App\Helpers\AuthHelper;

class PenerimaanInventarisController extends BaseController
{
    public function index()
    {
        // objek PenggunaModel
        $penerimaan_inv_mod = new PenerimaanInventarisModel();
        $beli_inv_mod = new PembelianInventarisModel();
        $inv_mod = new InventarisModel();

        $ptgm = new PetugasModel();
        $supm = new SuplierModel();
        $akbm = new AkunBayarModel();
        $rekm = new RekeningModel();
        $brgm = new InventarisBarangModel();

        $data = [
            'title' => 'Data Penerimaan Inventaris',
            'active_menu' => 'inventaris',
            'active_submenu' => 'penerimaan_inventaris',

            'pesan_inv_con' => $penerimaan_inv_mod->getData(),
            'beli_inv_con' => $beli_inv_mod->getData(),
            'ptgc' => $ptgm->getData(),
            'supc' => $supm->getData(),
            'akbc' => $akbm->getData(),
            'rekc' => $rekm->getData(),
            'brgc' => $brgm->getData(),
        ];


        return view('penerimaan_inventaris/index', $data);
    }

    public function detail($no_faktur)
    {
        $pem_inv_det_mod = new PembelianInventarisDetailModel();
        $detail = $pem_inv_det_mod->detailData($no_faktur);

        if ($detail) {
            // Kirim data dalam format JSON
            return $this->response->setJSON(['success' => true, 'detail' => $detail]);
        } else {
            return $this->response->setJSON(['success' => false]);
        }
    }

    public function add()
    {
        // Inisialisasi model
        $penerimaan_inv_mod = new PenerimaanInventarisModel();
        $pem_inv_det_mod = new PenerimaanInventarisDetailModel();
        $inv_mod = new InventarisModel();

        // Ambil data dari form
        $no_faktur = $this->request->getPost('no_faktur');

        // Cek apakah nomor faktur sudah ada di database
        if ($penerimaan_inv_mod->where('no_faktur', $no_faktur)->first()) {
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
            'kd_rek_aset' => $kd_rek_aset,

            // hitung subtotal, potongan, dll. jika diperlukan
        ];

        // Simpan data pembelian ke tabel inventaris_pembelian
        $penerimaan_inv_mod->insertData($dataPembelian);

        // Tentukan format tanggal untuk keperluan nomor inventaris (format Ymd)
        $tanggal = date('Y/m/d');

        for ($index = 0; $index < count($kode_barang); $index++) {
            // Ambil nilai jumlah dari setiap item
            $jumlahBarang = $jumlah[$index];

            // Loop untuk setiap jumlah barang
            for ($j = 0; $j < $jumlahBarang; $j++) {
                // Logika nomor inventaris tetap sama seperti sebelumnya
                $subtotal = $harga_beli[$index] * $jumlahBarang;
                $besardis = ($harga_beli[$index] * $jumlahBarang) * ($diskon[$index] / 100);
                $total = $subtotal - $besardis;

                // Cek inventaris terakhir
                $result = $inv_mod->getNoInventarisLast($tanggal);

                if ($result) {
                    $lastNoInventaris = $result['no_inventaris'];
                    $lastIncrement = (int)substr($lastNoInventaris, -3);
                    $newIncrement = $lastIncrement + 1;
                } else {
                    $newIncrement = 1;
                }

                $incrementFormatted = str_pad($newIncrement, 3, '0', STR_PAD_LEFT);
                $no_inventaris_baru = 'INV/' . $tanggal . '/' . $incrementFormatted;

                // Data inventaris baru
                $dataInventaris = [
                    'no_inventaris' => $no_inventaris_baru,
                    'kode_barang' => $kode_barang[$index],
                    'asal_barang' => 'Beli',
                    'tgl_pengadaan' => $tgl_pesan,
                    'harga' => $harga_beli[$index],
                    'status_barang' => 'Ada'
                ];

                // Simpan data inventaris ke database
                $inv_mod->insert($dataInventaris);
            }

            // Simpan data detail pembelian ke tabel inventaris_detail_beli
            $dataDetail = [
                'no_faktur' => $no_faktur,
                'kode_barang' => $kode_barang[$index],
                'jumlah' => $jumlah[$index],
                'harga' => $harga_beli[$index],
                'subtotal' => $subtotal,
                'dis' => $diskon[$index],
                'besardis' => $besardis,
                'total' => $total
            ];

            $pem_inv_det_mod->insert($dataDetail);
        }





        // Redirect atau tampilkan pesan sukses
        return redirect()->to('/penerimaan_inventaris')->with('success', 'Data penerimaan berhasil disimpan.');
    }

    public function edit($id)
    {
        // Inisialisasi model
        $penerimaan_inv_mod = new PenerimaanInventarisModel();
        $pem_inv_det_mod = new PembelianInventarisDetailModel();

        // Ambil data dari form
        $no_faktur = $this->request->getPost('no_faktur_new');

        if ($id != $no_faktur) {
            // Cek apakah nomor faktur sudah ada di database
            if ($penerimaan_inv_mod->where('no_faktur', $no_faktur)->first()) {
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
        $kode_barang = $this->request->getPost('2kode_barang'); // pastikan ini dikirim sebagai array
        $jumlah = $this->request->getPost('2jumlah'); // array
        $harga_beli = $this->request->getPost('2harga_beli'); // array
        $diskon = $this->request->getPost('2diskon'); // array
        $total = $this->request->getPost('2total'); // array

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
        $penerimaan_inv_mod->updateData($id, $dataPembelian);

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
        $penerimaan_inv_mod = new PenerimaanInventarisModel();

        $penerimaan_inv_mod->deleteData($id);

        session()->setFlashdata('success', 'dihapus');
        return redirect()->to('/penerimaan_inventaris');
    }

    public function print($id)
    {
        $penerimaan_inv_mod = new PenerimaanInventarisModel();
        $pem_inv_det_mod = new PenerimaanInventarisDetailModel();

        $data = [
            'pesan_inv_con' => $penerimaan_inv_mod->getDataById($id),
            'pesan_inv_det_con' => $pem_inv_det_mod->detailData($id),
        ];

        return view('penerimaan_inventaris/page_print', $data);
    }

    public function getFaktur()
    {
        $beli_inv_mod = new PembelianInventarisModel();
        $no_faktur = $this->request->getGet('no_faktur');
        if ($no_faktur) {
            $faktur = $beli_inv_mod->getDataById($no_faktur);
            if ($faktur) {
                return $this->response->setJSON($faktur);
            }
        }
        return $this->response->setJSON(null);
    }
}
