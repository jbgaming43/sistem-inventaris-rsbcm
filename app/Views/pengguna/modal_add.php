<div class="modal modal-blur fade" id="add_pengguna" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/pengguna/add" method="POST" class="validation_pengguna" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Username</label>
                        <div class="col">
                            <input type="text" class="form-control" name="username" placeholder="Masukkan username" id="username">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Nama</label>
                        <div class="col">
                            <input type="text" class="form-control" name="nama_pengguna" placeholder="Masukkan nama lengkap">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Level</label>
                        <div class="col">
                            <select class="form-select" name="level">
                                <option value="">- Pilih Level -</option>
                                <option value="Admin">Admin</option>
                                <option value="Petugas">Petugas</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label">No Telepon</label>
                        <div class="col">
                            <input type="text" class="form-control" name="no_telp" placeholder="Masukkan no telepon">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Password</label>
                        <div class="col">
                            <input type="password" class="form-control" name="password" placeholder="Masukkan password" id="password">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Ulangi Password</label>
                        <div class="col">
                            <input type="password" class="form-control" name="passconf" placeholder="Ulangi password">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label">Foto Profil</label>
                        <div class="col">
                            <input type="file" class="form-control" name="profile_image">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-seccondary" data-bs-dismiss="modal" onclick="resetForm('validation_pengguna')">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>