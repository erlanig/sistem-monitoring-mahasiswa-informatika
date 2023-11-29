<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\IRS;
use Illuminate\Http\Request;

class IRSController extends Controller
{
    public function edit($id_mhs)
    {
        $mahasiswa = Mahasiswa::find($id_mhs);

        $irs = IRS::join('Mahasiswa', 'IRS.id_mhs', '=', 'Mahasiswa.id_mhs')
            ->select('IRS.*')
            ->get();

        return view('mahasiswa.editmahasiswa', compact('mahasiswa', 'kota'));
    }

    public function update($id_mhs, Request $request)
    {
        $mahasiswa = IRS::find($id_mhs);
        $mahasiswa->update($request->all());
    
        return redirect()->route('mahasiswa.irs')->with([
            'success' => 'Data IRS berhasil diperbarui',
        ]);

    }
}
