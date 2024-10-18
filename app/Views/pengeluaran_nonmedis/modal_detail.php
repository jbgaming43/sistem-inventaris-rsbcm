<?php foreach ($pengeluaran_nonmedis_con as $dt_pengeluaran_nonmedis) : ?>
    <div class="modal fade" id="detail_pengeluaran_nonmedis<?= $dt_pengeluaran_nonmedis['no_keluar']; ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body text-center py-2">
                    <div id="detail-content-<?= $dt_pengeluaran_nonmedis['no_keluar']; ?>"></div>
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
        <?php foreach ($pengeluaran_nonmedis_con as $dt_pengeluaran_nonmedis) : ?>
                (function(modalId, detailContentId, detailUrl) {
                    document.getElementById(modalId).addEventListener('show.bs.modal', function() {
                        fetch(detailUrl)
                            .then(response => response.json())
                            .then(data => {
                                console.log(data);
                                if (data.success && Array.isArray(data.detail)) {
                                    var content = '<table class="table table-striped">';
                                    content += '<thead><tr><th>Kode Barang</th><th>Nama Barang</th><th>Kode Satuan</th><th>Jumlah</th><th>Harga</th><th>Total</th></tr></thead><tbody>';
                                    data.detail.forEach(item => {
                                        content += `<tr>
                                        <td>${item.kode_brng}</td>
                                        <td>${item.nama_brng}</td>
                                        <td>${item.kode_sat}</td>
                                        <td>${item.jumlah}</td>
                                        <td>Rp ${item.harga.toLocaleString('id-ID')}</td>
                                        <td>Rp ${item.total.toLocaleString('id-ID')}</td>
                                        </tr>`;
                                    });
                                    console.log(data.detail);
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
                    'detail_pengeluaran_nonmedis<?= $dt_pengeluaran_nonmedis['no_keluar']; ?>',
                    'detail-content-<?= $dt_pengeluaran_nonmedis['no_keluar']; ?>',
                    '<?= base_url('pengeluaran_non_medis/detail/' . $dt_pengeluaran_nonmedis['no_keluar']); ?>'
                );
        <?php endforeach; ?>
    });
</script>