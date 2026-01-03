<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;


class UserController extends Controller
{

    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list'  => ['Home', 'User']
        ];
        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];
        $activeMenu = 'user'; 
        $level = LevelModel::all(); 

        return view('user.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level, 
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request) 
{ 
    // Mengambil data user beserta relasi level-nya
    $users = UserModel::select('user_id', 'username', 'nama', 'level_id') 
                ->with('level'); 

    // Filter berdasarkan level jika ada yang dipilih
    if ($request->level_id) {
        $users->where('level_id', $request->level_id);
    }

    $data = $users->get();

    // Mengirim data JSON secara manual (Tanpa library Yajra)
    return response()->json([
        'draw' => intval($request->draw),
        'recordsTotal' => $data->count(),
        'recordsFiltered' => $data->count(),
        'data' => $data->map(function($user, $index) {
            return [
                'DT_RowIndex' => $index + 1,
                'username' => $user->username,
                'nama' => $user->nama,
                'level' => [
                    'level_nama' => $user->level->level_nama ?? '-'
                ],
                'aksi' => '
                    <a href="'.url('/user/' . $user->user_id).'" class="btn btn-info btn-sm">Detail</a>
                    <a href="'.url('/user/' . $user->user_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a>
                    <form class="d-inline-block" method="POST" action="'. url('/user/'.$user->user_id).'">
                        '.csrf_field().method_field('DELETE').'
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin?\');">Hapus</button>
                    </form>'
            ];
        })
    ]);
}

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list'  => ['Home', 'User', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah user baru'
        ];
        $level = LevelModel::all(); 
        $activeMenu = 'user'; 

        return view('user.create', compact('breadcrumb', 'page', 'level', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama'     => 'required|string|max:100',
            'password' => 'required|min:5',
            'level_id' => 'required|integer'
        ]);

        UserModel::create([
            'username' => $request->username,
            'nama'     => $request->nama,
            'password' => bcrypt($request->password), 
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user berhasil disimpan');
    }

    public function show(string $id)
    {
        $user = UserModel::with('level')->find($id);
        if (!$user) return redirect('/user')->with('error', 'Data user tidak ditemukan');

        $breadcrumb = (object) ['title' => 'Detail User', 'list' => ['Home', 'User', 'Detail']];
        $page = (object) ['title' => 'Detail user'];
        $activeMenu = 'user'; 

        return view('user.show', compact('breadcrumb', 'page', 'user', 'activeMenu'));
    }

    public function edit(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::all(); 
        if (!$user) return redirect('/user')->with('error', 'Data user tidak ditemukan');

        $breadcrumb = (object) ['title' => 'Edit User', 'list' => ['Home', 'User', 'Edit']];
        $page = (object) ['title' => 'Edit user'];
        $activeMenu = 'user'; 

        return view('user.edit', compact('breadcrumb', 'page', 'user', 'level', 'activeMenu'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username,'.$id.',user_id',
            'nama'     => 'required|string|max:100',
            'password' => 'nullable|min:5',
            'level_id' => 'required|integer'
        ]);

        $user = UserModel::find($id);
        $user->update([
            'username' => $request->username,
            'nama'     => $request->nama,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user berhasil diubah');
    }

    public function destroy(string $id)
    {
        $check = UserModel::find($id);
        if (!$check) return redirect('/user')->with('error', 'Data user tidak ditemukan');

        try {
            UserModel::destroy($id);
            return redirect('/user')->with('success', 'Data user berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/user')->with('error', 'Data user gagal dihapus karena terkait data lain');
        }
    }

    public function level()
{
    // Ini menghubungkan tabel m_user dengan m_level
    return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
}
}