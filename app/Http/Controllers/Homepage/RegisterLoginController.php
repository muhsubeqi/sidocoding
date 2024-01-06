<?php

namespace App\Http\Controllers\Homepage;

use App\Http\Controllers\Controller;
use App\Models\DataUser;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterLoginController extends Controller
{
    public function index()
    {
        return view('homepage/register-login/index');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->input('email'))->first();
        if ($user != null) {
            if ($user['status'] == 1 || $user['status'] == 2) {
                $credentials = $request->only('email', 'password');
                if (Auth::attempt($credentials)) {
                    return redirect()->intended('administrator/dashboard')->with('success-login', 'Anda Berhasil Login Menggunakan akun ' . $request->email);
                }else{
                    return redirect()->back()->with('failed-login', 'Password yang anda masukkan salah');
                }
            }
            else{
                return redirect()->back()->with('failed-login', 'Email belum diverifikasi');
            }
        }else{
            return redirect()->back()->with('failed-login', 'Email belum terdaftar');
        }
    }

    public function register(Request $request)
    {
        try {

            $dataValidated = $request->validate([
                'name' => 'required',
                'email' => 'required',
                'password' => 'required',
                'kode_phone' => 'required',
                'phone' => 'required',
            ]);
            
            $cek = User::where('email', $dataValidated['email'])->first();
            if ($cek != null) {
                return redirect()->back()->with('failed-register', "Gagal membuat akun baru, akun " . $dataValidated['email'] . " sudah tersedia!");
            }

            $remember_token = base64_encode($dataValidated['email']);

            DB::beginTransaction();
            
            User::create([
                'name' => $dataValidated['name'],
                'email' => $dataValidated['email'],
                'password' => Hash::make($dataValidated['password']),
                'remember_token' => $remember_token,
                'role' => 'member',
                'status' => '0'
            ]);

            $id = User::latest()->first()->id;

            $dataValidated['kode_phone'] = preg_replace("/[^0-9]/", "", $dataValidated['kode_phone']);
            
            DataUser::create([
                'users_id' => $id,
                'phone' => $dataValidated['kode_phone'] . $dataValidated['phone']
            ]);

            Mail::send('home', array('name' => $dataValidated['name'], 'remember_token' => $remember_token), function($pesan) use ($dataValidated){
                $pesan->to($dataValidated['email'], 'Verifikasi')->subject('Verifikasi alamat email Anda');
                $pesan->from('muhammadsubeqi0409@gmail.com', 'Admin Sidocoding');
            });  

            DB::commit();  

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->with('failed-register', "Gagal membuat akun baru " . $th->getMessage());
        }

        return redirect()->back()->with('success-register', "Berhasil membuat akun baru dengan nama " .  "<b>" . $dataValidated['name'] . "</b>" . '. Silahkan cek email ('. $dataValidated['email'] .') untuk menverifikasi akunmu terlebih dahulu sebelum login!' . '</br>' . '<a href="https://mail.google.com/" target="_blank">klik tautan ini untuk membuka gmail</a>');
    }

    public function verifikasi($token)
    {
        $user = User::where('remember_token', $token)->first();

        if($user->status == '0'){
            $user->status = '1';
        }

        $user->update([
            'status' => $user->status 
        ]);

        return redirect()->route('register-login')->with('success-register', "Verifikasi email berhasil! silahkan anda login");
    }
}
