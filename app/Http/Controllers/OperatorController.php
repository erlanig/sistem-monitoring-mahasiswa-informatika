<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Operator;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    public function index()
    {
        $nip = '130025897447586';
        $operator = Operator::where('Operator.NIP', $nip)
        ->leftJoin('Users', 'Operator.email', '=', 'Users.email')
        ->select('operator.*')
        ->first();

        return view('operator.dashboard', compact('operator'));

    }

    public function manajemenakun()
    {
        $operator = Operator::where('Operator.NIP', '130025897447586')
        ->select('operator.*')
        ->first();

        $mahasiswa = Mahasiswa::select('NIM', 'Nama')->get();

        return view('operator.manajemen', compact('operator', 'mahasiswa'));

    }

    // public function edit($isbn)
    // {
    //     $mahasiswa = mahasiswa::where('NIM', 'Nama')->first();
    //     return view('reset')->with(['mahasiswa' => $mahasiswa]);
    // }
}

