<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PengajuanBarangNonMedisModel;
use App\Models\PegawaiModel;
use App\Models\IpsrsBarangModel;
use App\Helpers\AuthHelper;

class PengajuanNonMedisController extends BaseController
{
    public function index()
    {
        // objek PenggunaModel
        $pbnm = new PengajuanBarangNonMedisModel();
        $pgwm = new PegawaiModel();
        $ipsrsbarang_mod = new IpsrsBarangModel();

        $data = [
            'title' => 'Data Pengajuan Non Medis',
            'active_menu' => 'non_medis',
            'active_submenu' => 'pengajuan_nonmedis',

            'pbnc' => $pbnm->getData(),
            'pgwc' => $pgwm->getData(),
            'ipsrsbarang_con' => $ipsrsbarang_mod->getData()
        ];


        return view('pengajuan_nonmedis/index', $data);
    }

    public function add()
    {
        // objek PenggunaModel
        $pbnm = new PengajuanBarangNonMedisModel();

        $no_pengajuan = $this->request->getPost('no_pengajuan');
        $tanggal = $this->request->getPost('tanggal');
        $nik = $this->request->getPost('nik');
        $keterangan = $this->request->getPost('keterangan');


        $data = [
            'no_pengajuan' => $no_pengajuan,
            'nip' => $nik,
            'tanggal' => $tanggal,
            'status' => 'Proses Pengajuan',
            'keterangan' => $keterangan,
        ];

        $pbnm->insertData($data);

        session()->setFlashdata('success', 'ditambahkan');
        return redirect()->to('/pengajuan_non_medis');
    }

    public function checkUsername()
    {
        $username = $this->request->getPost('username');
        $pm = new PengajuanBarangNonMedisModel();

        // mendapatkan username dalam database
        $result = $pm->where('username', $username)->first();

        if ($result) {
            // Username sudah digunakan
            echo json_encode(false);
        } else {
            // Username tersedia
            echo json_encode(true);
        }
    }

    public function edit($id)
    {
        $pm = new PengajuanBarangNonMedisModel();

        $data = [
            'nama_pengguna' => $this->request->getPost('nama_pengguna'),
            'level' => $this->request->getPost('level'),
            'no_telp' => $this->request->getPost('no_telp'),
        ];

        // Cek apakah file gambar baru diunggah
        $profile_image = $this->request->getFile('profile_image');
        $username = $this->request->getPost('old_username');
        if ($profile_image && $profile_image->isValid() && !$profile_image->hasMoved()) {
            // Mendapatkan ekstensi file
            $ext = $profile_image->getClientExtension();

            // Ubah nama file
            $newName = $username . '.' . $ext;
            $profile_image->move(ROOTPATH . 'public/assets/avatars', $newName);

            // Hapus gambar lama jika ada
            $pengguna = $pm->find($id);
            $oldImage = $pengguna['profile_image'];
            if ($oldImage !== 'default.jpg' && file_exists(ROOTPATH . 'public/assets/avatars/' . $oldImage)) {
                unlink(ROOTPATH . 'public/assets/avatars/' . $oldImage);
            }

            // Gunakan nama baru
            $data['profile_image'] = $newName;
        }

        $pm->updateData($id, $data);

        session()->setFlashdata('success', 'diedit');
        return redirect()->to('/pengguna');
    }

    public function delete($id)
    {
        $pm = new PengajuanBarangNonMedisModel();

        // Dapatkan data pengguna yang akan dihapus
        $pengguna = $pm->find($id);

        if ($pengguna['id'] == session()->get('id')) {
            session()->setFlashdata('error', 'tidak bisa menghapus akun sendiri');
            return redirect()->to('/pengguna');
        } else {
            // Hapus file gambar terkait jika bukan default.jpg
            if ($pengguna['profile_image'] !== 'default.jpg') {
                $imagePath = ROOTPATH . 'public/assets/avatars/' . $pengguna['profile_image'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $pm->deleteData($id);

            session()->setFlashdata('success', 'dihapus');
            return redirect()->to('/pengguna');
        }
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
}
