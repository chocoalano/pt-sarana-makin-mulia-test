<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Barang
 *
 * @property int $id
 * @property string $kode
 * @property string $name
 * @property string $lokasi
 * @property int $stok
 * @property string $satuan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PermintaanBarang[] $permintaan_barang
 * @property-read int|null $permintaan_barang_count
 * @method static \Illuminate\Database\Eloquent\Builder|Barang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Barang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Barang query()
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereKode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereLokasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereSatuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereStok($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Barang extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode',
        'name',
        'lokasi',
        'stok',
        'satuan',
    ];

    public function permintaan_barang()
    {
        return $this->hasMany(PermintaanBarang::class);
    }
}
