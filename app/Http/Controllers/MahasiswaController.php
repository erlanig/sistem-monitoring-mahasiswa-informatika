<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Kota;
use App\Models\Provinsi;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        //$mahasiswa = Mahasiswa::where('id_mhs', 1)->first();

        $mahasiswa = Mahasiswa::where('Mahasiswa.id_mhs', 1)
        ->leftJoin('IRS', 'Mahasiswa.id_mhs', '=', 'IRS.id_mhs')
        ->leftJoin('KHS', 'Mahasiswa.id_mhs', '=', 'KHS.id_mhs')
        ->leftJoin('PKL', 'Mahasiswa.id_mhs', '=', 'PKL.id_mhs')
        ->leftJoin('Skripsi', 'Mahasiswa.id_mhs', '=', 'Skripsi.id_mhs')
        ->leftjoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
        ->leftjoin('Kota_Kab', 'Mahasiswa.kode_kota_kab', '=', 'Kota_Kab.kode_kota_kab')
        ->select('Mahasiswa.*', 'Dosen.NIP AS nip', 'IRS.jumlah_sks AS sks', 'IRS.smst_aktif AS semaktif',
        'KHS.SKS_kumulatif AS skskum', 'KHS.SKS_semester AS skssem', 'KHS.IP_smt AS ipsem', 'KHS.IP_kumulatif AS ipk',
        'PKL.status_pkl AS statuspkl', 'PKL.nilai_pkl AS nilaipkl',
        'Skripsi.status_skripsi AS statusskripsi', 'Skripsi.nilai_skripsi AS nilaiskripsi', 'Skripsi.lama_studi AS lamastudi', 'Skripsi.tanggal_sidang AS tglsidang',
        'Kota_Kab.nama_kota_kab AS namakota')
        ->first();


        return view('mahasiswa.dashboard', compact('mahasiswa'));
    }

    /*public function edit($id_mhs)
    {
        $mahasiswa = Mahasiswa::find($id_mhs);

        $kota = Kota::join('Provinsi', 'Kota_Kab.kode_prov', '=', 'Provinsi.kode_prov')
        ->select('Kota_Kab.nama_kota_kab AS namakota', 'Provinsi.nama_prov AS namaprov')
        ->get();

        return view('mahasiswa.edit', compact('mahasiswa', 'kota'));
    }

    public function update(Request $request, $id_mhs)
    {
        $mahasiswa = Mahasiswa::find($id_mhs);
        $mahasiswa->update($request->except(['submit']));

        return redirect()->route('mahasiswa.edit')->with('success', 'Data Departemen berhasil diubah');

    }*/

    public function edit($id_mhs)
    {
        $mahasiswa = Mahasiswa::find($id_mhs);

        $kota = Kota::join('Provinsi', 'Kota_Kab.kode_prov', '=', 'Provinsi.kode_prov')
            ->select('Kota_Kab.kode_kota_kab', 'Kota_Kab.nama_kota_kab AS namakota', 'Provinsi.nama_prov AS namaprov')
            ->get();

        return view('mahasiswa.edit', compact('mahasiswa', 'kota'));
    }

    public function update($id_mhs, Request $request)
    {
        /*$validatedData = $request->validate([
            'nama' => 'required|string|max:50',
            'email' => 'required|email|max:50',
            'alamat' => 'required|string|max:50',
            'no_HP' => 'required|string|max:15',
            'angkatan' => 'required|string|max:4',
            'status' => 'required|string|max:15',
            'jalur_masuk' => 'required|string|max:10',
            'kode_kota_kab' => 'required|string|max:4',
        ]);*/

        $mahasiswa = Mahasiswa::find($id_mhs);
        $mahasiswa->update($request->all());

        if ($request->hasFile('foto')) {
            $request->file('foto')->move('fotoProfil/', $request->file('foto')->getClientOriginalName());
            $mahasiswa->foto = $request->file('foto')->getClientOriginalName();
            $mahasiswa->save();
        }


        return redirect()->route('mahasiswa.dashboard')->with([
            'success' => 'Data Buku berhasil diperbarui',
        ]);

    }

}
