<?php foreach ($pem_nonmedis_con as $dt_pembelian_nonmedis) : ?>
    <div class="modal fade" id="detail_pembelian_nonmedis<?= $dt_pembelian_nonmedis['no_faktur']; ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body text-center py-2">
                    <div id="detail-content-<?= $dt_pembelian_nonmedis['no_faktur']; ?>"></div>

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
        <?php foreach ($pem_nonmedis_con as $dt_pembelian_nonmedis) : ?>
                (function(modalId, detailContentId, detailUrl) {
                    document.getElementById(modalId).addEventListener('show.bs.modal', function() {
                        fetch(detailUrl)
                            .then(response => response.json())
                            .then(data => {
                                var content = '<table class="table table-striped">';
                                content += '<thead><tr><th>Kode Barang</th><th>Satuan</th><th>Jumlah</th><th>Harga</th><th>Subtotal</th><th>Diskon</th><th>Besar Diskon</th><th>Total</th></tr></thead><tbody>';
                                data.forEach(item => {
                                    content += `<tr>
                                    <td>${item.kode_brng}</td>
                                    <td>${item.kode_sat}</td>
                                    <td>${item.jumlah}</td>
                                    <td>${item.harga}</td>
                                    <td>${item.subtotal}</td>
                                    <td>${item.dis}</td>
                                    <td>${item.besardis}</td>
                                    <td>${item.total}</td>
                                </tr>`;
                                });
                                content += '<tr><td colspan="7"></td><th><?= $dt_pembelian_nonmedis['subtotal'] ?></th></tr><tbody>';
                                content += '</tbody></table>';
                                document.getElementById(detailContentId).innerHTML = content;
                            })
                            .catch(error => console.error('Error fetching details:', error));
                    });
                })(
                    'detail_pembelian_nonmedis<?= $dt_pembelian_nonmedis['no_faktur']; ?>',
                    'detail-content-<?= $dt_pembelian_nonmedis['no_faktur']; ?>',
                    '<?= base_url('pembelian_non_medis/detail/' . $dt_pembelian_nonmedis['no_faktur']); ?>'
                );
        <?php endforeach; ?>
    });
</script>