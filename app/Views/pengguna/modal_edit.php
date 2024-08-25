<?php foreach ($pc as $dt_pengguna) { ?>
    <div class="modal modal-blur fade" id="edit_pengguna<?= $dt_pengguna['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/pengguna/edit/<?= $dt_pengguna['id']; ?>" method="POST" class="validation_pengguna" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-2 row">
                            <label class="col-3 col-form-label">Username</label>
                            <div class="col">
                                <input type="hidden" class="form-control" name="old_username" value="<?= $dt_pengguna['username']; ?>">
                                <input type="text" class="form-control" name="username" value="<?= $dt_pengguna['username']; ?>" disabled>
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label class="col-3 col-form-label required">Nama</label>
                            <div class="col">
                                <input type="text" class="form-control" name="nama_pengguna" placeholder="Masukkan nama lengkap" value="<?= $dt_pengguna['nama_pengguna']; ?>">
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label class="col-3 col-form-label required">Level</label>
                            <div class="col">
                                <select class="form-select" name="level">
                                    <?= $lvl = $dt_pengguna['level']; ?>
                                    <option value="" <?= $lvl == '' ? 'selected' : null; ?>>- Pilih Level -</option>
                                    <option value="Admin" <?= $lvl == 'Admin' ? 'selected' : null; ?>>Admin</option>
                                    <option value="Petugas" <?= $lvl == 'Petugas' ? 'selected' : null; ?>>Petugas</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label class="col-3 col-form-label">No Telepon</label>
                            <div class="col">
                                <input type="text" class="form-control" name="no_telp" placeholder="Masukkan no telepon" value="<?= $dt_pengguna['no_telp']; ?>">
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label class="col-3 col-form-label">Foto Profil</label>
                            <div class="col-auto">
                                <span class="avatar avatar-sm" style="background-image: url(<?= base_url('assets/avatars/') . $dt_pengguna['profile_image']; ?>)"></span>
                            </div>
                            <div class="col">
                                <input type="file" class="form-control" name="profile_image">
                                <small class="form-hint">Kosongkan jika tidak merubah gambar.</small>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="modal-body">
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
                    </div> -->
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
<?php } ?>