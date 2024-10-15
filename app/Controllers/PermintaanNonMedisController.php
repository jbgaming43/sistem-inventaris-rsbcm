<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PermintaanModel;
use App\Helpers\AuthHelper;

class PermintaanController extends BaseController
{
    public function index()
    {
        // objek PermintaanModel
        $pengguna_mod = new PermintaanModel();

        $data = [
            'title' => 'Data Pengguna',
            'active_menu' => 'master',
            'active_submenu' => 'pengguna',

            'pengguna_con' => $pengguna_mod->getData()
        ];

        return view('pengguna/index', $data);
    }

    public function add()
    {
        // objek PermintaanModel
        $pengguna_mod = new PermintaanModel();

        // Upload file
        $profile_image = $this->request->getFile('profile_image');

        if ($profile_image && $profile_image->isValid() && !$profile_image->hasMoved()) {
            // Mendapatkan ekstensi file
            $ext = $profile_image->getClientExtension();

            $newName = $this->request->getPost('username') . '.' . $ext;
            $profile_image->move(ROOTPATH . 'public/assets/avatars', $newName);
        } else {
            $newName = 'default.jpg';
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'nama_pengguna' => $this->request->getPost('nama_pengguna'),
            'level' => $this->request->getPost('level'),
            'no_telp' => $this->request->getPost('no_telp'),
            'profile_image' => $newName,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $pengguna_mod->insertData($data);

        session()->setFlashdata('success', 'ditambahkan');
        return redirect()->to('/pengguna');
    }

    public function edit($id)
    {
        $pengguna_mod = new PermintaanModel();

        $pengguna_mod->updateData($id, $data);

        session()->setFlashdata('success', 'diedit');
        return redirect()->to('/pengguna');
    }

    public function delete($id)
    {
        $pengguna_mod = new PermintaanModel();

        // Dapatkan data pengguna yang akan dihapus
        $pengguna = $pengguna_mod->find($id);

        $pengguna_mod->deleteData($id);

        session()->setFlashdata('success', 'dihapus');
        return redirect()->to('/pengguna');
    }
}
