<?php

namespace App\Controllers;

use App\Models\InventarisBarangModel;
use App\Models\InventarisModel;
use App\Models\RekeningModel;
use App\Models\RuangModel;
use App\Models\SuplierModel;
use CodeIgniter\Controller;
use App\Models\PenerimaanInventarisModel;
use App\Models\PembelianInventarisModel;
use App\Models\PembelianInventarisDetailModel;
use App\Models\PenerimaanInventarisDetailModel;
use App\Models\GaransiModel;
use App\Models\PetugasModel;
use App\Models\AkunBayarModel;
use App\Helpers\AuthHelper;

use App\Libraries\phpqrcode\qrlib;
use DateTime;

class PenerimaanInventarisController extends BaseController
{
    public function index()
    {
        // objek PenggunaModel
        $penerimaan_inv_mod = new PenerimaanInventarisModel();
        $pembelian_inv_mod = new PembelianInventarisModel();
        $inv_mod = new InventarisModel();
        $ruang_mod = new RuangModel();

        $ptgm = new PetugasModel();
        $supm = new SuplierModel();
        $akbm = new AkunBayarModel();
        $rekm = new RekeningModel();
        $brgm = new InventarisBarangModel();

        $data = [
            'title' => 'Data Penerimaan Inventaris',
            'active_menu' => 'inventaris',
            'active_submenu' => 'penerimaan_inventaris',

            'penerimaan_inv_con' => $penerimaan_inv_mod->getData(),
            'pembelian_inv_con' => $pembelian_inv_mod->getData(),
            'ptgc' => $ptgm->getData(),
            'supc' => $supm->getData(),
            'akbc' => $akbm->getData(),
            'rekc' => $rekm->getData(),
            'brgc' => $brgm->getData(),
            'inv_con' => $inv_mod->getData(),
            'ruang_con' => $ruang_mod->getData(),
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
        $tanggal = date('Y-m-d');

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
                $no_inventaris_baru = 'INV-' . $tanggal . '-' . $incrementFormatted;

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
        $penerimaan_inv_det_mod = new PenerimaanInventarisDetailModel();

        $data = [
            'penerimaan_inv_con' => $penerimaan_inv_mod->getDataById($id),
            'penerimaan_inv_det_con' => $penerimaan_inv_det_mod->detailData($id),
        ];

        return view('penerimaan_inventaris/page_print', $data);
    }

    public function getFaktur()
    {
        $pembelian_inv_mod = new PembelianInventarisModel();
        $no_faktur = $this->request->getGet('no_faktur');
        if ($no_faktur) {
            $faktur = $pembelian_inv_mod->getDataById($no_faktur);
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
        $tes = base_url('penerimaan_inventaris/info/') . $id;

        $data = [
            'inv_con' => $inv_mod->getDataById($id),
        ];

        return view('penerimaan_inventaris/page_info', $data);
    }

    public function generateQR($id)
    {
        // Load library PHP QR Code
        require_once(APPPATH . 'Libraries/phpqrcode/qrlib.php');
        $id = str_replace('/', '-', $id);
        // Set folder untuk menyimpan QR Code
        $tempDir = FCPATH . 'uploads/'; // Pastikan folder ini ada
        $fileName = $tempDir . 'qrcode_' . $id . '.png'; // Buat nama file berdasarkan ID

        // Konten QR Code
        $codeContents = base_url('penerimaan_inventaris/info/') . $id;

        // Generate QR Code dan simpan di file
        \QRcode::png($codeContents, $fileName, QR_ECLEVEL_L, 10);

        return $fileName; // Kembalikan nama file untuk digunakan
    }

    public function page_qr($id)
    {
        $penerimaan_inv_mod = new PenerimaanInventarisModel();
        $penerimaan_inv_det_mod = new PenerimaanInventarisDetailModel();
        $inv_mod = new InventarisModel();

        // Ambil data inventaris_pemesanan
        $data_penerimaan = $penerimaan_inv_mod->getDataById($id);
        $data_detail_penerimaan = $penerimaan_inv_det_mod->detailData($id);

        // Mendapatkan tanggal faktur
        foreach ($data_penerimaan as $dt_penerimaan) {
            $tgl_faktur = $dt_penerimaan['tgl_pesan'];
        }

        $kode_barang = [];
        foreach ($data_detail_penerimaan as $dt_detail_penerimaan) {
            $kode_barang[] = $dt_detail_penerimaan['kode_barang'];
        }

        // Ambil data barang berdasarkan beberapa kode_barang dan tgl_faktur
        $barang = $inv_mod->getDataBytgl_kd($tgl_faktur, $kode_barang);

        $qrImages = []; // Array untuk menyimpan nama file QR Code

        // Buat QR code untuk setiap no_inventaris dari barang yang didapat
        foreach ($barang as $data_barang) {
            $no_inventaris = $data_barang['no_inventaris']; // Ambil no_inventaris
            $fileName = $this->generateQR($no_inventaris); // Panggil fungsi generateQR untuk setiap no_inventaris
            $qrImages[] = $fileName; // Simpan nama file ke array
        }

        $data = [
            'title' => 'Data Penerimaan Inventaris',
            'active_menu' => 'inventaris',
            'active_submenu' => 'penerimaan_inventaris',
            'qrImages' => $qrImages
        ];
        // Tampilkan QR Code dalam view
        return view('penerimaan_inventaris/page_qr', $data);
    }

    public function add_ruang()
    {
        $inv_mod = new InventarisModel();

        $no_inventaris = $this->request->getPost('no_inventaris');
        $id_ruang = $this->request->getPost('id_ruang');

        $data = [
            'no_inventaris' => $no_inventaris,
            'id_ruang' => $id_ruang,
        ];

        $inv_mod->updateRuang($no_inventaris,$data);
        return redirect()->to('/penerimaan_inventaris')->with('success', 'Data penerimaan berhasil disimpan.');
    }

    public function add_garansi()
    {
        $inv_mod = new InventarisModel();
        $garansi_mod = new GaransiModel();

        $no_inventaris = $this->request->getPost('no_inventaris');
        $data = $inv_mod->getDataById($no_inventaris);
        //$tgl_pengadaan = $data['tgl_pengadaan'];
        foreach($data as $val)
        {
            $tgl_pengadaan = $val['tgl_pengadaan'];
        }
        $date = new DateTime($tgl_pengadaan);
        
        $hari = $this->request->getPost('hari');
        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');
        $date->add(new \DateInterval('P'.$hari.'D'));
        $date->add(new \DateInterval('P'.$bulan.'M'));
        $date->add(new \DateInterval('P'.$tahun.'Y'));

        $date = $date->format('Y-m-d');

        $data = [
            'no_inventaris' => $no_inventaris,
            'garansi' => $date,
        ];

        $garansi = $garansi_mod->getDataById($no_inventaris);
        if($garansi)
        {
            $garansi_mod->updateData($no_inventaris,$data);
        }
        else
        {
            $garansi_mod->insertData($data);
        }
        return redirect()->to('/penerimaan_inventaris')->with('success', 'Data penerimaan berhasil disimpan.');
    }
}
