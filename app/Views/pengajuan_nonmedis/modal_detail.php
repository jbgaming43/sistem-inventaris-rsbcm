<?php foreach ($pbnc as $dt_pengajuan_nonmedis) : ?>
    <div class="modal fade" id="detail_pengajuan_nonmedis<?= $dt_pengajuan_nonmedis['no_pengajuan']; ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body text-center py-2">
                    <div id="detail-content-<?= $dt_pengajuan_nonmedis['no_pengajuan']; ?>"></div>

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
        <?php foreach ($pbnc as $dt_pengajuan_nonmedis) : ?>
                (function(modalId, detailContentId, detailUrl) {
                    document.getElementById(modalId).addEventListener('show.bs.modal', function() {
                        fetch(detailUrl)
                            .then(response => response.json())
                            .then(data => {
                                console.log(data);
                                var content = '<table class="table table-striped">';
                                content += '<thead><tr><th>Kode Barang</th><th>Jumlah</th><th>Harga</th><th>Satuan</th><th>Total</th></tr></thead><tbody>';
                                data.forEach(item => {
                                    content += `<tr>
                                    <td>${item.kode_brng}</td>
                                    <td>${item.jumlah}</td>
                                    <td>${item.h_pengajuan}</td>
                                    <td>${item.kode_sat}</td>
                                    <td>${item.total}</td>
                                </tr>`;
                                });
                                content += '<tr><td colspan="6"></td><th></th></tr><tbody>';
                                content += '</tbody></table>';
                                document.getElementById(detailContentId).innerHTML = content;
                            })
                            .catch(error => console.error('Error fetching details:', error));
                            document.getElementById(detailContentId).innerHTML = 'Error: Data tidak valid atau tidak ditemukan.';
                    });
                })(
                    'detail_pengajuan_nonmedis<?= $dt_pengajuan_nonmedis['no_pengajuan']; ?>',
                    'detail-content-<?= $dt_pengajuan_nonmedis['no_pengajuan']; ?>',
                    '<?= base_url('pengajuan_non_medis/detail/' . $dt_pengajuan_nonmedis['no_pengajuan']); ?>'
                );
        <?php endforeach; ?>
    });
</script>