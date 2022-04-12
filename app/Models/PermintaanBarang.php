<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PermintaanBarang
 *
 * @property int $id
 * @property int $barang_id
 * @property int $qty
 * @property string $keterangan
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Barang|null $barang
 * @method static \Illuminate\Database\Eloquent\Builder|PermintaanBarang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermintaanBarang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermintaanBarang query()
 * @method static \Illuminate\Database\Eloquent\Builder|PermintaanBarang whereBarangId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermintaanBarang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermintaanBarang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermintaanBarang whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermintaanBarang whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermintaanBarang whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermintaanBarang whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PermintaanBarang extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'barang_id',
        'qty',
        'keterangan',
        'status',
        'tanggal_permintaan',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
