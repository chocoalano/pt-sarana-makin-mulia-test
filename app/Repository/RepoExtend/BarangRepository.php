<?php

namespace App\Repository\RepoExtend;

use App\Repository\AppBusinessProcessEloquent;
use App\Models\Barang;

class BarangRepository extends AppBusinessProcessEloquent
{
    protected $model;

    public function __construct(Barang $model)
    {
        $this->model = $model;
    }

    public function fieldset()
    {
        return array(
            'kode',
            'name',
            'lokasi',
            'stok',
            'satuan',
        );
    }

    public function form_validation($id)
    {
        return array(
            'kode' => (!empty($id)) ? 'required|string|unique:barangs,kode,' . $id : 'required|string|unique:barangs,kode',
            'name' => 'required|string',
            'lokasi' => 'required|string',
            'stok' => 'required|numeric',
            'satuan' => 'required|string|in:pak,pcs'
        );
    }
}
