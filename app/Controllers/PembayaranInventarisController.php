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
use App\Models\PembayaranInventarisModel;
use App\Models\AkunBayarHutangModel;
use App\Models\GaransiModel;
use App\Models\PetugasModel;
use App\Models\AkunBayarModel;
use App\Helpers\AuthHelper;

use App\Libraries\phpqrcode\qrlib;
use DateTime;

class PembayaranInventarisController extends BaseController
{
    public function index()
    {
        // objek PenggunaModel

        $pembayaran_inv_mod = new PembayaranInventarisModel();
        $penerimaan_inv_mod = new PenerimaanInventarisModel();
        $petugas_mod = new PetugasModel();
        $akun_bayar_hutang_mod = new AkunBayarHutangModel();

        $data = [
            'title' => 'Data Pembayaran Inventaris',
            'active_menu' => 'inventaris',
            'active_submenu' => 'pembayaran_inventaris',

            'pembayaran_inv_con' => $pembayaran_inv_mod->getData(),
            'penerimaan_inv_con' => $penerimaan_inv_mod->getData(),
            'akun_bayar_hutang_con' => $akun_bayar_hutang_mod->getData(),
            'ptgc' => $petugas_mod->getData(),
        ];


        return view('pembayaran_inventaris/index', $data);
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
        $pembayaran_inv_mod = new PembayaranInventarisModel();

        // Ambil data dari form
        $no_faktur = $this->request->getPost('no_faktur');

        // Cek apakah nomor faktur sudah ada di database
        if ($pembayaran_inv_mod->where('no_faktur', $no_faktur)->first()) {
            return redirect()->back()->with('error', 'Nomor faktur sudah ada, gunakan nomor faktur yang berbeda.');
        }
        $tgl_bayar = $this->request->getPost('tgl_bayar');
        $nip = $this->request->getPost('nip');
        $besar_bayar = $this->request->getPost('besar_bayar');
        $keterangan = $this->request->getPost('keterangan');
        $nama_bayar = $this->request->getPost('nama_bayar');
        $no_bukti = $this->request->getPost('no_bukti');

        $data = 
        [
            'tgl_bayar' => $tgl_bayar,
            'no_faktur' => $no_faktur,
            'nip' => $nip,
            'besar_bayar' => $besar_bayar,
            'keterangan' => $keterangan,
            'nama_bayar' => $nama_bayar,
            'no_bukti' => $no_bukti,
        ];

        $pembayaran_inv_mod->insertData($data);

        // Redirect atau tampilkan pesan sukses
        return redirect()->to('/pembayaran_inventaris')->with('success', 'Data penerimaan berhasil disimpan.');
    }

    public function delete($id)
    {
        $pembayaran_inv_mod = new PembayaranInventarisModel();

        $pembayaran_inv_mod->deleteData($id);

        session()->setFlashdata('success', 'dihapus');
        return redirect()->to('/pembayaran_inventaris');
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

        $combinedData = []; // Array untuk menyimpan data barang beserta QR code

        // Asumsikan jumlah $barang dan $qrImages sama
        foreach ($barang as $key => $data_barang) {
            $combinedData[] = [
                'barang' => $data_barang,    // Data barang
                'qrImage' => $qrImages[$key] // QR code yang terkait dengan barang
            ];
        }

        $data = [
            'title' => 'Data QR Penerimaan Inventaris',
            'active_menu' => 'inventaris',
            'active_submenu' => 'penerimaan_inventaris',

            'penerimaan_inv_con' => $penerimaan_inv_mod->getDataById($id),
            'no_faktur' => $id,
            'qrImages' => $qrImages,
            'barang_qrImage' => $combinedData,
            'total_barang' => count($barang)
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

        $inv_mod->updateRuang($no_inventaris, $data);
        return redirect()->to('/penerimaan_inventaris')->with('success', 'Data penerimaan berhasil disimpan.');
    }

    public function add_garansi()
    {
        $inv_mod = new InventarisModel();
        $garansi_mod = new GaransiModel();

        $no_inventaris = $this->request->getPost('no_inventaris');
        $data = $inv_mod->getDataById($no_inventaris);
        //$tgl_pengadaan = $data['tgl_pengadaan'];
        foreach ($data as $val) {
            $tgl_pengadaan = $val['tgl_pengadaan'];
        }
        $date = new DateTime($tgl_pengadaan);

        $hari = $this->request->getPost('hari');
        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');
        $date->add(new \DateInterval('P' . $hari . 'D'));
        $date->add(new \DateInterval('P' . $bulan . 'M'));
        $date->add(new \DateInterval('P' . $tahun . 'Y'));

        $date = $date->format('Y-m-d');

        $data = [
            'no_inventaris' => $no_inventaris,
            'garansi' => $date,
        ];

        $garansi = $garansi_mod->getDataById($no_inventaris);
        if ($garansi) {
            $garansi_mod->updateData($no_inventaris, $data);
        } else {
            $garansi_mod->insertData($data);
        }
        return redirect()->to('/penerimaan_inventaris')->with('success', 'Data penerimaan berhasil disimpan.');
    }

    public function print_qr($id)
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

        $combinedData = []; // Array untuk menyimpan data barang beserta QR code

        // Asumsikan jumlah $barang dan $qrImages sama
        foreach ($barang as $key => $data_barang) {
            $combinedData[] = [
                'barang' => $data_barang,    // Data barang
                'qrImage' => $qrImages[$key] // QR code yang terkait dengan barang
            ];
        }

        $data = [
            'no_faktur' => $id,
            'qrImages' => $qrImages,
            'barang_qrImage' => $combinedData
        ];
        // Tampilkan QR Code dalam view
        return view('penerimaan_inventaris/page_print_qr', $data);
    }
}
