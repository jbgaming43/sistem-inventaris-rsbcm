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
        // Inisialisasi model
        $pembelianModel = new PembelianInventarisModel();
        $detailModel = new PembelianInventarisDetailModel();

        // Mulai transaksi
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // Ambil data dari form
            $no_faktur = $this->request->getPost('no_faktur');
            $kode_suplier = $this->request->getPost('kode_suplier');
            $nip = $this->request->getPost('nip');
            $tgl_beli = $this->request->getPost('tgl_beli');
            $kd_rek = $this->request->getPost('kd_rek'); // Akun Bayar
            $kd_rek_aset = $this->request->getPost('kd_rek_aset'); // Akun Jenis

            // Ambil data array untuk detail pembelian
            $kode_barang = $this->request->getPost('kode_barang');
            $jumlah = $this->request->getPost('jumlah');
            $harga = $this->request->getPost('harga');
            $subtotal_array = $this->request->getPost('subtotal');
            $dis = $this->request->getPost('dis');
            $besardis = $this->request->getPost('besardis');
            $total_array = $this->request->getPost('total');

            // Hitung subtotal, potongan, total untuk inventaris_pembelian
            $subtotal_pembelian = 0;
            $potongan_pembelian = 0;
            $total_pembelian = 0;

            // Debug data sebelum foreach
            var_dump($kode_barang);
            var_dump($jumlah);
            var_dump($harga);

            // Loop untuk menyimpan detail pembelian
            foreach ($kode_barang as $index => $kb) {
                $subtotal = str_replace(['Rp', ','], '', $subtotal_array[$index]);
                $besardis_val = str_replace(['Rp', ','], '', $besardis[$index]);
                $total = str_replace(['Rp', ','], '', $total_array[$index]);

                // Dapatkan data per baris untuk detail pembelian
                $data_detail = [
                    'no_faktur' => $no_faktur,
                    'kode_barang' => $kb,
                    'jumlah' => $jumlah[$index],
                    'harga' => $harga[$index],
                    'subtotal' => $subtotal,
                    'dis' => $dis[$index],
                    'besardis' => $besardis_val,
                    'total' => $total,
                ];

                // Simpan ke tabel `inventaris_detail_beli`
                $detailModel->insertData($data_detail);

                // Update total pembelian
                $subtotal_pembelian += floatval($subtotal);
                $potongan_pembelian += floatval($besardis_val);
                $total_pembelian += floatval($total);
            }

            // Data untuk tabel `inventaris_pembelian`
            $ppn = 0; // Bisa disesuaikan jika ada PPN
            $materai = 0; // Bisa disesuaikan jika ada materai
            $tagihan = $total_pembelian; // Sesuaikan jika ada biaya tambahan seperti PPN atau materai

            $data_pembelian = [
                'no_faktur' => $no_faktur,
                'kode_suplier' => $kode_suplier,
                'nip' => $nip,
                'tgl_beli' => $tgl_beli,
                'subtotal' => $subtotal_pembelian,
                'potongan' => $potongan_pembelian,
                'total' => $total_pembelian,
                'ppn' => $ppn,
                'materai' => $materai,
                'tagihan' => $tagihan,
                'kd_rek' => $kd_rek,
                'kd_rek_aset' => $kd_rek_aset,
            ];

            // Simpan ke tabel `inventaris_pembelian`
            $pembelianModel->insertData($data_pembelian);

            // Commit transaksi
            if ($db->transStatus() === false) {
                // Jika ada error, rollback
                $db->transRollback();
                session()->setFlashdata('error', 'Gagal menambahkan data pembelian.');
            } else {
                // Jika sukses, commit
                $db->transCommit();
                session()->setFlashdata('success', 'Data pembelian berhasil ditambahkan.');
            }

            return redirect()->to('/pembelian_inventaris');
        } catch (\Exception $e) {
            // Jika ada exception, rollback dan tampilkan pesan error
            $db->transRollback();
            session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
            return redirect()->to('/pembelian_inventaris');
        }
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
