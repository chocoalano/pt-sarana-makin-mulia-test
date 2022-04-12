<?php

namespace App\Repository\RepoExtend;

use App\Repository\AppBusinessProcessEloquent;
use App\Models\PermintaanBarang;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class PermintaanBarangRepository extends AppBusinessProcessEloquent
{
    protected $model;

    public function __construct(PermintaanBarang $model)
    {
        $this->model = $model;
    }

    public function fieldset()
    {
        return array(
            'user_id',
            'barang_id',
            'qty',
            'keterangan',
            'status',
            'tanggal_permintaan',
        );
    }

    public function form_validation()
    {
        return array(
            'user_id' => 'required|numeric',
            'barang_id' => 'required|numeric',
            'qty' => 'required|numeric',
            'keterangan' => 'required|string',
            'status' => 'required|string|in:terpenuhi,tidak terpenuhi',
            'tanggal_permintaan' => 'required|date_format:Y-m-d',
        );
    }

    public function paginated($search, $sortBy, $sortDesc, $perpage, $fieldsearch)
    {
        try {
            $sortby = ($sortBy == '') ? 'ps.created_at' : $sortBy;
            $sortdesc = ($sortDesc !== '' && $sortDesc == true) ? 'DESC' : 'ASC';
            $u =DB::table('users as us')
            ->join('model_has_roles as mhr', 'mhr.model_id', '=', 'us.id')
            ->join('roles as rs', 'rs.id', '=', 'mhr.role_id')
            ->join('permintaan_barangs as ps', 'ps.user_id', '=', 'us.id')
            ->join('barangs as brg', 'brg.id', '=', 'ps.barang_id')
            ->orderBy($sortby, $sortdesc);
            if ($search != '') {
                $u->where(function ($query) use ($search) {
                    $query->where('brg.name', 'LIKE', '%' . $search. '%');
                    $query->where('brg.kode', 'LIKE', '%' . $search. '%');
                    $query->where('brg.lokasi', 'LIKE', '%' . $search. '%');
                    $query->where('rs.name', 'LIKE', '%' . $search. '%');
                });
            }
            $u->select('us.nik','rs.name as departemen','brg.kode as kode_brg','brg.name as name_brg','brg.lokasi as lokasi_brg','ps.*');
            $data = $u->paginate($perpage);
            $response['response'] = $data;
            $response['code'] = Response::HTTP_OK;
        } catch (\Exception $e) {
            $response['response'] = $e->getMessage();
            $response['code'] = Response::HTTP_BAD_REQUEST;
        }
        return $response;
    }
}
