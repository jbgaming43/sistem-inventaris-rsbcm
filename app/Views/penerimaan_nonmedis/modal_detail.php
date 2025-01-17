<?php foreach ($penerimaan_nonmedis_con as $dt_penerimaan_nonmedis) : ?>
    <div class="modal fade" id="detail_penerimaan_nonmedis<?= $dt_penerimaan_nonmedis['no_faktur']; ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body text-center py-2">
                    <div id="detail-content-<?= $dt_penerimaan_nonmedis['no_faktur']; ?>"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php foreach ($penerimaan_nonmedis_con as $dt_penerimaan_nonmedis) : ?>
                (function(modalId, detailContentId, detailUrl) {
                    document.getElementById(modalId).addEventListener('show.bs.modal', function() {
                        fetch(detailUrl)
                            .then(response => response.json())
                            .then(data => {
                                if (data.success && Array.isArray(data.detail)) {
                                    var content = '<table class="table table-striped">';
                                    content += '<thead><tr><th>Kode Barang</th><th>Nama Barang</th><th>Jumlah</th><th>Harga</th><th>Subtotal</th><th>Diskon</th><th>Besar Diskon</th><th>Total</th></tr></thead><tbody>';
                                    data.detail.forEach(item => {
                                        content += `<tr>
                                        <td>${item.kode_brng}</td>
                                        <td>${item.nama_brng}</td>
                                        <td>${item.jumlah}</td>
                                        <td>${item.harga}</td>
                                        <td>${item.subtotal}</td>
                                        <td>${item.dis}</td>
                                        <td>${item.besardis}</td>
                                        <td>${item.total}</td>
                                        </tr>`;
                                    });
                                    console.log(data.detail);
                                    content += '<tr><td colspan="7"></td><th><?= $dt_penerimaan_nonmedis['total1'] ?></th></tr><tbody>';
                                    content += '</tbody></table>';
                                    document.getElementById(detailContentId).innerHTML = content;
                                } else {
                                    console.error('Error: Data tidak valid atau tidak ditemukan.');
                                    document.getElementById(detailContentId).innerHTML = 'Error: Data tidak valid atau tidak ditemukan.';
                                }
                            })

                            .catch(error => console.error('Error fetching details:', error));
                    });
                })(
                    'detail_penerimaan_nonmedis<?= $dt_penerimaan_nonmedis['no_faktur']; ?>',
                    'detail-content-<?= $dt_penerimaan_nonmedis['no_faktur']; ?>',
                    '<?= base_url('penerimaan_non_medis/detail/' . $dt_penerimaan_nonmedis['no_faktur']); ?>'
                );
        <?php endforeach; ?>
    });
</script>