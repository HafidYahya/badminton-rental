<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserManagementController extends Controller
{
    // Fungsi ketika membuka menu KELOLA PENGGUNA, langsung menampilkan list mengambil data dari database dan mengirmkannya ke view dengan compact
    public function index(){
        $users = User::latest()->get();
        return view('pages.admin.UserManagementPage.index', compact('users'));
    }

    public function create(){
        return view('pages.admin.UserManagementPage.create');
    }

    public function store(Request $request) {
         $request->validate([
            'username'      => 'required|min:5|unique:users,u_username|alpha_dash',
            'nama_lengkap'  => 'required|max:20|regex:/^[A-Za-z\s]+$/',
            'password'      => 'required|min:8|max:100',
            'konfirmasi_password' => 'required|same:password',
            'foto_profile'  => 'mimes:jpg,jpeg,png,webp,heic|max:2048' ,           
        ],[
            'username.required' => 'Username tidak boleh kosong',
            'username.min' => 'Username minimal harus 5 karakter',
            'username.unique' => 'Username ini sudah digunakan',
            'username.alpha_dash' => 'Username tidak boleh ada spasi',
            'nama_lengkap.max' => 'Maksimal 20 karakter',
            'nama_lengkap.regex' => 'Tidak boleh menggunakan nomor atau simbol',
            'nama_lengkap.required' => 'Nama lengkap tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 8 karakter',
            'password.max' => 'Password maksimal 100 karakter',
            'konfirmasi_password.same' => 'Password tidak cocok',
            'foto_profile.mimes' => 'Format file harus JPG, JPEG, PNG, WEBP, atau HEIC',
        ]);

        // Validasi apakah ada foto yang di upload
        $filename ='undraw_profile.svg'; //Ini Profile Default
        if($request->hasFile('foto_profile')){

            $file = $request->file('foto_profile');

            // Nama File Baru
            $filename = time().'.'.$file->getClientOriginalExtension();

            // Pindahkan ke folder uploads/users
            $file->move(public_path('/uploads/users'), $filename); //Parameter pertama adalah path, parameter kedua adalah nama file
        }

        // Insert Ke database (Table Users)
        DB::table('users')->insert([
            'u_username' => $request->username,
            'u_nama_lengkap' => $request->nama_lengkap,
            'u_foto_profile' => $filename,
            'u_password' => bcrypt($request->password),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
            return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan!');

        
    }

    // Fungsi untuk menampilkan halaman Edit
    public function edit(User $user)
    {
        return view('pages.admin.UserManagementPage.edit', compact('user'));
    }

    
    public function update(Request $request, User $user){
        $request->validate([
            'username'      => 'required|min:5|unique:users,u_username,'.$user->u_id.',u_id',
            'nama_lengkap'  => 'required|max:20|regex:/^[A-Za-z\s]+$/',
            'password'      => 'nullable|min:8|max:100',
            'konfirmasi_password' => 'nullable|same:password',
            'foto_profile'  => 'mimes:jpg,jpeg,png,webp,heic|max:2048' ,           
        ],[
            'username.min' => 'Username minimal harus 5 karakter',
            'username.unique' => 'Username ini sudah digunakan',
            'username.alpha_dash' => 'Username tidak boleh ada spasi',
            'nama_lengkap.max' => 'Maksimal 20 karakter',
            'nama_lengkap.regex' => 'Tidak boleh menggunakan nomor atau simbol',
            'password.min' => 'Password minimal 8 karakter',
            'password.max' => 'Password maksimal 100 karakter',
            'konfirmasi_password.same' => 'Password tidak cocok',
            'foto_profile.mimes' => 'Format file harus JPG, JPEG, PNG, WEBP, atau HEIC',
        ]);
        // Update field dasar
        $user->u_username = $request->username;
        $user->u_nama_lengkap = $request->nama_lengkap;

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->u_password = bcrypt($request->password);
        }

        // Update foto profile jika ada file baru
        if ($request->hasFile('foto_profile')) {
            // Hapus foto lama jika ada
            if ($user->u_foto_profile && File::exists(public_path('uploads/users/'.$user->u_foto_profile))) {
                if($user->u_foto_profile !== 'undraw_profile.svg'){
                    File::delete(public_path('uploads/users/'.$user->u_foto_profile));
                }
            }
            // Simpan file baru
            $file = $request->file('foto_profile');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/users'), $fileName);
            $user->u_foto_profile = $fileName;
        }

        $user->save();

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui.');
    }


    public function destroy($id){
        $user=User::find($id);
        if($user->u_foto_profile && File::exists(public_path('uploads/users/'. $user->u_foto_profile))){
            if($user->u_foto_profile !== 'undraw_profile.svg'){
                File::delete(public_path('uploads/users/'.$user->u_foto_profile));
            }
        }
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus');
    }
}