<?php
namespace App\Models;

use CodeIgniter\Model;

class PembelianInventarisDetailModel extends Model
{
    protected $table = 'inventaris_detail_beli';
    protected $primaryKey = 'no_faktur';
    protected $allowedFields = [
        'no_faktur', 'kode_barang', 'jumlah', 'harga', 'subtotal', 'dis', 'besardis', 'total'
    ];

    // Fungsi untuk menyimpan detail pembelian
    public function insertData($data)
    {
        return $this->insert($data);
    }
}
?>