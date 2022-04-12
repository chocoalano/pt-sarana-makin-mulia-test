<?php

namespace App\Http\Controllers\API\Master;

use App\Http\Controllers\Controller;
use App\Repository\RepoExtend\PermintaanBarangRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermintaanBarangController extends Controller
{
    protected $proses;
    function __construct(PermintaanBarangRepository $proses)
    {
        $this->proses = $proses;

        $this->middleware('permission:permintaan_barang-list|permintaan_barang-create|permintaan_barang-edit|permintaan_barang-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:permintaan_barang-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:permintaan_barang-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:permintaan_barang-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request()->search;
        $sortBy = request()->sortBy;
        $sortDesc = request()->sortDesc;
        $perpage = request()->perpage;
        $fieldsearch = $this->proses->fieldset();
        $data = $this->proses->paginated(
            $search,
            $sortBy,
            $sortDesc,
            $perpage,
            $fieldsearch,
        );
        return response()->json(['response' => $data['response']], $data['code']);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $attr['user'] = DB::table('users as us')->join('model_has_roles as mhr', 'mhr.model_id', '=', 'us.id')->join('roles as rs', 'rs.id', '=', 'mhr.role_id')->select('us.id', 'us.nik', 'us.name', 'rs.name as departemen')->get();
        $attr['barang'] = DB::table('barangs')->get();
        return response()->json($attr);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        foreach ($input['data'] as $key) {
            $send = [
                'user_id' => $input['user_id'],
                'barang_id' => $key['barang_id'],
                'qty' => $key['qty'],
                'keterangan' => (!empty($key['keterangan']))?$key['keterangan']:'-',
                'status' => $key['status'],
                'tanggal_permintaan' => $input['tanggal_permintaan'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $rules = $this->proses->form_validation();
            $data = $this->proses->valid($send, $rules);
            if ($data['code'] == 200) {
                $data = $this->proses->store($send);
            }
        }
        return response()->json(['response' => $data['response']], $data['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->proses->show($id);
        return response()->json(['response' => $data['response']], $data['code']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->proses->editEloquent($id);
        return response()->json(['response' => $data['response']], $data['code']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $rules = $this->proses->form_validation();
        $data = $this->proses->valid($input, $rules);
        if ($data['code'] == 200) {
            $data = $this->proses->update($id, $input);
        }
        return response()->json(['response' => $data['response']], $data['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->proses->delete($id);
        return response()->json(['response' => $data['response']], $data['code']);
    }
}
