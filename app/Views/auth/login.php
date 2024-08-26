<?= $this->include('layouts/header') ?>
<div class="page page-center">
    <div class="container container-tight py-4">
        <div class="text-center mb-4">
            <h1>SI Inventaris Barang RSBCM</h1>
        </div>
        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">Login </h2>
                <?= $this->include('layouts/alert') ?>
                <form action="<?= base_url('/login') ?>" method="POST" autocomplete="off">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" placeholder="Masukkan username" autocomplete="off">
                        <?php if (isset($validation) && $validation->hasError('username')) : ?>
                            <small class="text-danger">
                                <?= $validation->getError('username') ?>
                            </small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">
                            Password
                            <!-- <span class="form-label-description">
                                <a href="./forgot-password.html">I forgot password</a>
                            </span> -->
                        </label>
                        <div class="input-group input-group-flat">
                            <input type="password" class="form-control" name="password" placeholder="Masukkan password" autocomplete="off">
                            <span class="input-group-text">
                                <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg>
                                </a>
                            </span>
                        </div>
                        <?php if (isset($validation) && $validation->hasError('password')) : ?>
                            <small class="text-danger">
                                <?= $validation->getError('password') ?>
                            </small>
                        <?php endif; ?>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-green w-100">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?= $this->include('layouts/footer_page') ?>
</div>
<?= $this->include('layouts/footer') ?>