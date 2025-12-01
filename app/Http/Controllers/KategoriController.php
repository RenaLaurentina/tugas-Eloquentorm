<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index()
    {
        /* $data = [
            'kategori_kode' => 'SSA01',
            'kategori_nama' => 'Furnitur',
            'created_at'    => now()
        ];

        DB::table('m_kategori')->insert($data);
        return 'Insert data kategori berhasil'; */

       // $row = DB::table('m_kategori') ->where('kategori_kode', 'SSA01') ->update(['kategori_nama' => 'Perabotan Rumah']);
       // return 'Update data berhasil. Jumlah data yang diupdate: ' . $row . ' baris';

       // $row = DB::table('m_kategori') ->where('kategori_kode', 'SSA01') ->delete();
       // return 'Delete data berhasil. Jumlah data dihapus: ' . $row . ' baris';

       $data = DB::table('m_kategori')->get();
       return view('kategori', ['data'=> $data]);

    
    }
}
