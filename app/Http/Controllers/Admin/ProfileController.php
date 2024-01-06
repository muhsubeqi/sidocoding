<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataUser;
use App\Models\User;
use App\Http\Services\BulkData;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    private $folder = 'admin/profile';
    public function index()
    {
        $user = DataUser::where('users_id', auth()->user()->id)->first();
        
        // hitung umur
        if (isset($user->ttl)) {
            $tanggalLahir = explode(',', $user->ttl)[1];

            $birthDate = new DateTime($tanggalLahir);
            $today = new DateTime("today");
            if ($birthDate > $today) {
            }
            $y = $today->diff($birthDate)->y;
            $m = $today->diff($birthDate)->m;
            $d = $today->diff($birthDate)->d;
    
            $umur = $y . " tahun " . $m . " bulan " . $d . " hari";
        } else{
            $umur = '';
        }
       
        $photo = auth()->user()->photo;
        return view("$this->folder/index", compact('user', 'umur', 'photo'));
    }

    public function edit()
    {
        $dataUser = DataUser::where('users_id', auth()->user()->id)->first();

        if ($dataUser->ttl != null) {
            $dataUser->tempat_lahir = explode(',', $dataUser->ttl)[0];
            $dataUser->tanggal_lahir = explode(',', $dataUser->ttl)[1];
        }

        return view("$this->folder/edit", compact('dataUser'));
    }

    public function update(Request $request)
    {
        try {
            $dataValidated = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|max:255|email',
                'tempat_lahir' => 'nullable|max:255',
                'tanggal_lahir' => 'nullable|max:255',
                'jenis_kelamin' => 'nullable|max:255',
                'alamat' => 'nullable|max:255',
                'phone' => 'nullable|max:255'
            ]);

            $namaFoto = $request->input('foto_lama');

            if ($request->has('photo')) {
                $lokasi = 'data/user/image';
                $foto = $request->file('photo');
                $extensi = $request->file('photo')->extension();
                $new_image_name = 'Photo' . date('YmdHis') . uniqid() . '.' . $extensi;
                $upload = $foto->move(public_path($lokasi), $new_image_name);
                $namaFoto = $new_image_name;
                if ($upload) {
                    $getFoto = auth()->user()->photo;
                    if ($getFoto != null) {
                        File::delete(public_path('data/user/image/' . $getFoto));
                    }
                }
            }
            
            if ($request->has('password')) {
                $passValidated = $request->validate([
                    'password' => 'required|max:255',
                    'konfirmasi_password' => 'required|same:password'
                ]);
                $dataValidated['password'] = $passValidated['password'];
                $dataValidated['konfirmasi_password'] = $passValidated['konfirmasi_password'];
            }
            
            $birth = $dataValidated['tempat_lahir'] . ", " . $dataValidated['tanggal_lahir'];
            $userId = auth()->user()->id;
       
            DB::beginTransaction();
            DataUser::where('users_id', $userId)
                ->update([
                    'ttl' => $birth,
                    'jenis_kelamin' => $dataValidated['jenis_kelamin'],
                    'alamat' => $dataValidated['alamat'],
                    'phone' => $dataValidated['phone']
                ]);
            
            if ($request->has('password')) {
                User::where('id', $userId)
                    ->update([
                        'name' => $dataValidated['name'],
                        'email' => $dataValidated['email'],
                        'password' => Hash::make($dataValidated['password']),
                        'photo' => $namaFoto
                    ]);
            } else {
                User::where('id', $userId)
                    ->update([
                        'name' => $dataValidated['name'],
                        'email' => $dataValidated['email'],
                        'photo' => $namaFoto
                    ]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            return redirect()->route('admin.profile')->with('failed', 'Gagal mengupdate profile');
        }
        return redirect()->route('admin.profile')->with('message', 'Berhasil mengupdate profile');
    }

}