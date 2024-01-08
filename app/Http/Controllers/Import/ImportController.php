<?php

namespace App\Http\Controllers\Import;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Import\ImportAbsensiHdrModels;
use App\Models\Import\ImportAbsensiDtlModels;
use App\Imports\AbsensiImport;

use Redirect, Response;
use DateTime;
use DB;
use Excel;

class ImportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Import.ImportAbsensi');    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data_hdr['file_name']      = $request->filename;
        $data_hdr['user_at']        = 'System';        

        $data_save_hdr = ImportAbsensiHdrModels::create($data_hdr);
        
        $data_update = [
            'id_hdr' => $data_save_hdr->id,
            'user_at' => $data_save_hdr->user_at
        ];
        ImportAbsensiDtlModels::where('id_hdr', 0)->update($data_update);

        $msg = 'Data berhasil di simpan';
        return response()->json(['success' => true, 'message' => $msg, 'id_hdr' => $data_save_hdr->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function importFile(Request $request)
    {
        $path= $request->file('exampleInputFile')->getRealPath();        
        $data = Excel::import(new AbsensiImport,$path);
        // dd($data);
        // die();

        // // menangkap file excel
        // $file = $request->file('exampleInputFile');
 
        // // membuat nama file unik
        // $nama_file = rand().$file->getClientOriginalName();
 
        // // upload ke folder file_siswa di dalam folder public
        // $file->move('file_absensi',$nama_file);
 
        // // import data
        // Excel::import(new AbsensiImport, public_path('/file_absensi/'.$nama_file));

        $msg = 'Data berhasil di simpan';
        return response()->json(['success' => true, 'message' => $msg]);
    }

    public function list_data_hdr(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'DT_RowIndex',
            2 => 'file_name',
            3 => 'created_at'
        );

        $id_hdr = $request->id_hdr;
        $totalData = DB::table('trx_absen_hdr')
            ->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = DB::table('trx_absen_hdr')
                ->offset($start)
                ->limit($limit)
                ->orderBy('file_name')
                ->get();
        } else {
            $search = $request->input('search.value');

            $posts =  DB::table('trx_absen_hdr')
                ->offset($start)
                ->limit($limit)
                ->where([['file_name', 'LIKE', "%{$search}%"]])
                // ->orWhere([['nama', 'LIKE', "%{$search}%"]])
                ->orderBy('file_name')
                ->get();

            $totalFiltered = DB::table('trx_absen_hdr')
                ->where([['file_name', 'LIKE', "%{$search}%"]])
                // ->orWhere([['nama', 'LIKE', "%{$search}%"]])
                ->count();
        }

        $data = array();
        $i = $start + 1;
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $nestedData['id'] = $post->id;
                $nestedData['DT_RowIndex'] = $i;
                $nestedData['file_name'] = $post->file_name;
                $nestedData['created_at'] = $post->created_at;                
                $data[] = $nestedData;
                $i++;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }

    public function list_data_dtl(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'DT_RowIndex',
            2 => 'nik',
            3 => 'nama',
            4 => 'tanggal',
            5 => 'status'
        );

        $id_hdr = $request->id_hdr;
        $totalData = DB::table('trx_absen')
            ->where([['id_hdr', '=', $id_hdr]])
            ->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = DB::table('trx_absen')
                ->offset($start)
                ->limit($limit)
                ->where([['id_hdr', '=', $id_hdr]])
                ->orderBy('nik')
                ->get();
        } else {
            $search = $request->input('search.value');

            $posts =  DB::table('trx_absen')
                ->offset($start)
                ->limit($limit)
                ->where([['id_hdr', '=', $id_hdr], ['nik', 'LIKE', "%{$search}%"]])
                ->orWhere([['id_hdr', '=', $id_hdr], ['nama', 'LIKE', "%{$search}%"]])
                ->orderBy('nik')
                ->get();

            $totalFiltered = DB::table('trx_absen')
                ->where([['id_hdr', '=', $id_hdr], ['nik', 'LIKE', "%{$search}%"]])
                ->orWhere([['id_hdr', '=', $id_hdr], ['nama', 'LIKE', "%{$search}%"]])
                ->count();
        }

        $data = array();
        $i = $start + 1;
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $nestedData['id'] = $post->id;
                $nestedData['DT_RowIndex'] = $i;
                $nestedData['nik'] = $post->nik;
                $nestedData['nama'] = $post->nama;
                $nestedData['tanggal'] = $post->tanggal;
                $nestedData['status'] = $post->status;                
                $data[] = $nestedData;
                $i++;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }

    /**
    *    @OA\Get(
    *       path="/v1/data",
    *       tags={"Berita"},
    *       operationId="kategoriBerita",
    *       summary="Kategori Berita",
    *       description="Mengambil Data",
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data",
    *               "data": {
    *                   {
    *                   "id": "1",
    *                   "nama_kategori": "Pendidikan",
    *                  }
    *              }
    *          }),
    *      ),
    *  )
    */

    public function get_data(Request $request)
    {
        $id_hdr = 1;
        $data = DB::table('trx_absen')
                    ->where([['id_hdr', '=', $id_hdr]])
                    ->get();
        return $data;
    }
}
