<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PengajuanInventarisModel;
use App\Models\PegawaiModel;
use App\Helpers\AuthHelper;

class PengajuanInventarisController extends BaseController
{
    public function index()
    {
        // objek PenggunaModel
        $pbnm = new PengajuanInventarisModel();
        $pgwm = new PegawaiModel();

        $data = [
            'title' => 'Data Pengajuan Inventaris',
            'active_menu' => 'inventaris',
            'active_submenu' => 'pengajuan_inventaris',

            'pbnc' => $pbnm->getData(),
            'pgwc' => $pgwm->getData(),
        ];
        

        return view('pengajuan_inventaris/index', $data);
    }

    public function add()
    {
        // objek PenggunaModel
        $pbnm = new PengajuanInventarisModel();

        $jumlah = $this->request->getPost('jumlah');
        $harga = $this->request->getPost('harga');
        $total = $jumlah*$harga;

        $data = [
            'no_pengajuan' => $this->request->getPost('no_pengajuan'),
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

        $pbnm->insertData($data);

        session()->setFlashdata('success', 'ditambahkan');
        return redirect()->to('/pengajuan_inventaris');
    }

    public function checkUsername()
    {
        $username = $this->request->getPost('username');
        $pbnm = new PengajuanInventarisModel();

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
        $pbnm = new PengajuanInventarisModel();

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
        $pbnm = new PengajuanInventarisModel();

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
}
