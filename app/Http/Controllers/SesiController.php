<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;

class SesiController extends Controller
{
    function index()
    {
        return view('logins.login');
    }

    function login(Request $request)
    {
        $mahasiswa = Mahasiswa::where('Mahasiswa.id_mhs', 1)
        ->leftJoin('Users', 'Mahasiswa.email', '=', 'Users.email')
        ->select('Mahasiswa.email', 'Users.*')
        ->first();

        $request->validate(
            [
                'email'=>'required',
                'password'=>'required'
            ],
            [
                'email.required'=>'Email harus diisi!',
                'password.required'=>'Password harus diisi!'
            ],
        );

        $infologin = [
            'email'=>$request->email,
            'password'=>$request->password,
        ];

        if(Auth::attempt($infologin)){
            if(Auth::user()->role == 'operator'){
                return redirect('operator/dashboard');
            } elseif(Auth::user()->role == 'dosen'){
                return redirect('dosen/dashboard');
            } elseif(Auth::user()->role == 'departemen'){
                return redirect('departemen/dashboard');
            } elseif(Auth::user()->role == 'mahasiswa'){
                // if(Auth::user()->alamat == ''){
                //     return redirect()->route('mahasiswa.edit', ['id_mhs' => $mahasiswa->id_mhs]);
                // }
                return redirect('mahasiswa/dashboard');
            }
        }
        else{
            return redirect('')->withErrors('Email atau password salah')->withInput();
        }
    }

    function logout()
    {
        Auth::logout();
        return redirect('');
    }
}
