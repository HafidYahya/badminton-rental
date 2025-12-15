<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use SweetAlert2\Laravel\Swal;

class CustomerController extends Controller
{

    public function index()
    {
        $customer = Customer::all();
        return view('pages.admin.customer.index', compact('customer'));
    }
    public function registerForm()
    {
        return view('pages.customer.register');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|max:20|regex:/^[A-Za-z\s]+$/',
            'no_hp' => 'required|numeric|digits_between:9,15',
            'username' => 'required|alpha_dash|unique:customer,c_username',
            'password' => 'required|min:8',
            'konfirmasi_password' => 'required|min:8|same:password',
            'alamat' => 'nullable',
            'foto_profile' => 'mimes:jpg,jpeg,png,webp,heic|max:2048'
        ], [
            'nama_lengkap.required' => 'Nama lengkap tidak boleh kosong',
            'nama_lengkap.max' => 'Maksimal 20 karakter',
            'nama_lengkap.regex' => 'Nama lengkap tidak boleh mengandung simbol atau angka',
            'no_hp.required' => 'Nomor handphone tidak boleh kosong',
            'no_hp.numeric' => 'Hanya menerima angka',
            'no_hp.digits_between' => 'Minimal 9 nomor',
            'username.required' => 'Username tidak boleh kosong',
            'username.alpha_dash' => 'Username tidak boleh menggunakan spasi',
            'username.unique' => 'username sudah terdaftar',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Minimal 8 karakter',
            'konfirmasi_password.required' => 'Konfirmasi Password tidak boleh kosong',
            'konfirmasi_password.min' => 'Minimal 8 karakter',
            'konfirmasi_password.same' => 'Password tidak sesuai',
            'foto_profile.mimes' => 'Format file harus JPG, JPEG, PNG, WEBP, atau HEIC',
            'foto_profile.max' => 'Maksimal 2 Mb',
        ]);

        $fileName = 'undraw_profile.svg';
        if ($request->hasFile('foto_profile')) {
            $file = $request->file('foto_profile');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/customers'), $fileName);
        }

        DB::table('customer')->insert([
            'c_nama_lengkap' => $request->nama_lengkap,
            'c_no_hp' => $request->no_hp,
            'c_username' => $request->username,
            'c_password' => bcrypt($request->password),
            'c_alamat' => $request->alamat,
            'c_foto_profile' => $fileName,
            'c_is_member' => 'N',
            'c_status' => 'active',
            'c_tanggal_daftar' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Swal::fire([
            'title' => 'Berhasil!',
            'text' => 'Anda berhasil mendaftar, silahkan login',
            'icon' => 'success',
            'showConfirmButton' => true,
        ]);
        return redirect()->route('login.customer.form');
    }
    // EDIT
    public function editProfileCustomer($id)
    {
        $customer = Customer::find($id);
        return view('pages.customer.edit', compact('customer'));
    }
    public function updateProfileCustomer(Request $request, Customer $customer)
    {
        $request->validate([
            'nama_lengkap' => 'required|max:20|regex:/^[A-Za-z\s]+$/',
            'no_hp' => 'required|numeric|digits_between:9,15',
            'username' => 'required|alpha_dash|unique:customer,c_username,' . $customer->c_id . ',c_id',
            'password' => 'nullable|min:8',
            'konfirmasi_password' => 'nullable|min:8|same:password',
            'alamat' => 'nullable',
            'foto_profile' => 'mimes:jpg,jpeg,png,webp,heic|max:2048'
        ], [
            'nama_lengkap.required' => 'Nama lengkap tidak boleh kosong',
            'nama_lengkap.max' => 'Maksimal 20 karakter',
            'nama_lengkap.regex' => 'Nama lengkap tidak boleh mengandung simbol atau angka',
            'no_hp.required' => 'Nomor handphone tidak boleh kosong',
            'no_hp.numeric' => 'Hanya menerima angka',
            'no_hp.digits_between' => 'Minimal 9 nomor',
            'username.required' => 'Username tidak boleh kosong',
            'username.alpha_dash' => 'Username tidak boleh menggunakan spasi',
            'username.unique' => 'username sudah terdaftar',
            'password.min' => 'Minimal 8 karakter',
            'konfirmasi_password.min' => 'Minimal 8 karakter',
            'konfirmasi_password.same' => 'Password tidak sesuai',
            'foto_profile.mimes' => 'Format file harus JPG, JPEG, PNG, WEBP, atau HEIC',
            'foto_profile.max' => 'Maksimal 2 Mb',
        ]);
        $customer->c_nama_lengkap = $request->nama_lengkap;
        $customer->c_no_hp = $request->no_hp;
        $customer->c_username = $request->username;
        $customer->c_alamat = $request->alamat;

        // Cek password baru
        if ($request->filled('password')) {
            $customer->c_password = bcrypt($request->password);
        }
        // cek file foto
        if ($request->hasFile('foto_profile')) {
            if ($customer->c_foto_profile && File::exists(public_path('uploads/customers/' . $customer->c_foto_profile))) {
                if ($customer->c_foto_profile !== 'undraw_profile.svg') {
                    File::delete(public_path('uploads/customers/' . $customer->c_foto_profile));
                }
            }
            $file = $request->file('foto_profile');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/customers'), $fileName);
            $customer->c_foto_profile = $fileName;
        }
        $customer->save();
        Swal::fire([
            'title' => 'Berhasil!',
            'text' => 'Profil berhasil diperbarui.',
            'icon' => 'success',
            'timer' => 2000,
            'showConfirmButton' => false,
        ]);
        return back();
    }
    // END EDIT
    public function activateMember($id)
    {
        $customer = Customer::find($id);
        $customer->c_is_member = 'Y';
        $customer->save();
        return back();
    }
    public function deactivateMember($id)
    {
        $customer = Customer::find($id);
        $customer->c_is_member = 'N';
        $customer->save();
        return back();
    }
    public function status($id)
    {
        $customer = Customer::find($id);
        $customer->c_status = $customer->c_status === 'active' ? 'inactive' : 'active';
        $customer->save();
        return back();
    }
}
