<?php foreach ($pem_nonmedis_con as $dt_pembelian_nonmedis) { ?>
    <div class="modal modal-blur fade" id="delete_pembelian_nonmedis<?= $dt_pembelian_nonmedis['no_faktur']; ?>" tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-status bg-danger"></div>
                <div class="modal-body text-center py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z"></path>
                        <path d="M12 9v4"></path>
                        <path d="M12 17h.01"></path>
                    </svg>
                    <h3>Hapus data</h3>
                    <div class="text-muted">Apakah anda yakin ingin menghapus data <strong><?= $dt_pembelian_nonmedis['no_faktur']; ?></strong>?</div>
                </div>
                <div class="modal-footer">
                    <form action="/pembelian_non_medis/delete/<?= $dt_pembelian_nonmedis['no_faktur']; ?>" method="POST">
                        <div class="w-100">
                            <div class="row">
                                <div class="col"><button type="button" class="btn w-100" data-bs-dismiss="modal">
                                        Batal
                                    </button></div>
                                <div class="col"><button type="submit" class="btn btn-danger w-100">
                                        Hapus
                                    </button></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>