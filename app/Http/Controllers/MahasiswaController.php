<?php

namespace App\Http\Controllers;

use App\Models\IRS;
use App\Models\KHS;
use App\Models\Mahasiswa;
use App\Models\Kota;
use App\Models\PKL;
use App\Models\Provinsi;
use App\Models\Skripsi;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        $user = auth()->user();
    
        // Query to get the latest record
        $mahasiswa = Mahasiswa::where('Mahasiswa.email', $user->email)
            ->leftJoin('IRS', function($join) {
                $join->on('Mahasiswa.id_mhs', '=', 'IRS.id_mhs')
                     ->where('IRS.persetujuan', '<>', 'Belum Disetujui');
            })
            ->leftJoin('KHS', function($join) {
                $join->on('Mahasiswa.id_mhs', '=', 'KHS.id_mhs')
                     ->where('KHS.persetujuan', '<>', 'Belum Disetujui');
            })
            ->leftJoin('PKL', function($join) {
                $join->on('Mahasiswa.id_mhs', '=', 'PKL.id_mhs')
                     ->where('PKL.persetujuan', '<>', 'Belum Disetujui');
            })
            ->leftJoin('Skripsi', function($join) {
                $join->on('Mahasiswa.id_mhs', '=', 'Skripsi.id_mhs')
                     ->where('Skripsi.persetujuan', '<>', 'Belum Disetujui');
            })
            ->leftjoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
            ->leftjoin('Kota_Kab', 'Mahasiswa.kode_kota_kab', '=', 'Kota_Kab.kode_kota_kab')
            ->select('Mahasiswa.*', 'Dosen.NIP AS nip', 'IRS.jumlah_sks AS sks', 'IRS.smst_aktif AS semaktif',
                'KHS.SKS_kumulatif AS skskum', 'KHS.SKS_semester AS skssem', 'KHS.IP_smt AS ipsem', 'KHS.IP_kumulatif AS ipk',
                'PKL.status_pkl AS statuspkl', 'PKL.nilai_pkl AS nilaipkl',
                'Skripsi.status_skripsi AS statusskripsi', 'Skripsi.nilai_skripsi AS nilaiskripsi', 'Skripsi.lama_studi AS lamastudi', 'Skripsi.tanggal_sidang AS tglsidang',
                'Kota_Kab.nama_kota_kab AS namakota', 'IRS.id_irs AS idirs', 'IRS.persetujuan AS persetujuan_irs', 'KHS.persetujuan AS persetujuan_khs', 'PKL.persetujuan AS persetujuan_pkl', 'Skripsi.persetujuan AS persetujuan_skripsi',
                'KHS.smt_aktif AS smtKHS')
            ->orderBy('IRS.id_irs', 'desc')
            ->orderBy('KHS.id_khs', 'desc')
            ->orderBy('PKL.id_pkl', 'desc')
            ->orderBy('Skripsi.id_skripsi', 'desc')
            ->first();
    
        // If no record is found, fetch the second latest record
        if (!$mahasiswa) {
            $mahasiswa = Mahasiswa::where('Mahasiswa.email', $user->email)
                ->leftJoin('IRS', 'Mahasiswa.id_mhs', '=', 'IRS.id_mhs')
                ->leftJoin('KHS', 'Mahasiswa.id_mhs', '=', 'KHS.id_mhs')
                ->leftJoin('PKL', 'Mahasiswa.id_mhs', '=', 'PKL.id_mhs')
                ->leftJoin('Skripsi', 'Mahasiswa.id_mhs', '=', 'Skripsi.id_mhs')
                ->leftjoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
                ->leftjoin('Kota_Kab', 'Mahasiswa.kode_kota_kab', '=', 'Kota_Kab.kode_kota_kab')
                ->select('Mahasiswa.*', /* other fields */)
                ->orderBy('IRS.id_irs', 'desc')
                ->orderBy('KHS.id_khs', 'desc')
                ->orderBy('PKL.id_pkl', 'desc')
                ->orderBy('Skripsi.id_skripsi', 'desc')
                ->skip(1)  // Skip the last record
                ->first();
        }
    
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
        $mahasiswa = Mahasiswa::find($id_mhs);

        //Validasi input, termasuk konfirmasi password
        $validatedData = $request->validate([
            'nama' => 'required|string|max:50',
            'email' => 'required|email|max:50',
            'alamat' => 'required|string|max:50',
            'no_HP' => 'required|string|max:15',
            'angkatan' => 'required|string|max:4',
            'status' => 'required|string|max:15',
            'jalur_masuk' => 'required|string|max:10',
            'kode_kota_kab' => 'string|max:4',
            'password' => 'nullable|min:6|confirmed', // confirmed akan memvalidasi password_confirmation
        ]);

        // Update data mahasiswa
        $mahasiswa->update($validatedData);


        if ($request->hasFile('foto')) {
            $request->file('foto')->move('fotoProfil/', $request->file('foto')->getClientOriginalName());
            $mahasiswa->foto = $request->file('foto')->getClientOriginalName();
        }

        // Update the password if provided
        if ($request->filled('password')) {
            $password = bcrypt($request->input('password'));
            $user = User::where('email', $mahasiswa->email)->first();
            $user->update(['password' => $password]);
        }

        $mahasiswa->save();

        return redirect()->route('mahasiswa.dashboard')->with([
            'success' => 'Data diri berhasil diperbarui',
        ]);
    }

    public function updateirs($id_mhs, Request $request)
    {
        $mahasiswa = IRS::find($id_mhs);
        $mahasiswa->create($request->all());

        return redirect()->route('mahasiswa.dashboard')->with([
            'success' => 'Data IRS berhasil diperbarui',
        ]);

    }

    public function entryirs($id_mhs)
    {
        $mahasiswa = Mahasiswa::find($id_mhs);

        $irs = IRS::join('Mahasiswa', 'IRS.id_mhs', '=', 'Mahasiswa.id_mhs')
            ->where('IRS.id_mhs', $id_mhs)
            ->orderBy('IRS.id_irs', 'desc')
            ->select('IRS.*')
            ->first();

        $irsExists = $irs ? true : false;

        return view('mahasiswa.irs', compact('mahasiswa', 'irs', 'irsExists'));
    }

    public function createirs($id_mhs, Request $request)
    {
        $request->validate([
            'smst_aktif' => 'required|numeric',
            'jumlah_sks' => 'required|numeric',
            'berkas_irs' => 'required|file|mimes:pdf|max:10000'
        ], [
            'smst_aktif.required' => 'Semester Aktif wajib diisi!',
            'jumlah_sks.required' => 'Jumlah SKS wajib diisi!',
            'jumlah_sks.numeric' => 'Jumlah SKS harus berupa angka!',
            'smst_aktif.numeric' => 'Semester Aktif harus berupa angka!',
            'berkas_irs.required' => 'Berkas IRS wajib diisi!',
            'berkas_irs.file' => 'Berkas IRS harus berupa file!',
            'berkas_irs.mimes' => 'Berkas IRS harus berupa file PDF!',
        ]);


        // Buat IRS yang baru
        $irs = new IRS();
        $irs->smst_aktif = $request->input('smst_aktif');
        $irs->jumlah_sks = $request->input('jumlah_sks');
        $irs->status_irs = 'Terisi';
        $irs->id_mhs = $id_mhs;

        if ($request->hasFile('berkas_irs')) {
            $request->file('berkas_irs')->move('berkasIRS/', $request->file('berkas_irs')->getClientOriginalName());
            $irs->berkas_irs = $request->file('berkas_irs')->getClientOriginalName();
        }

        $irs->save();

        return redirect()->route('mahasiswa.dashboard')->with([
            'success' => 'Data IRS berhasil dibuat',
        ]);
    }


    public function entrykhs($id_mhs, Request $request)
    {

        // Cari data mahasiswa
        $mahasiswa = Mahasiswa::find($id_mhs);

        // Pastikan mahasiswa ditemukan
        if (!$mahasiswa) {
            return redirect()->route('mahasiswa.dashboard')->with([
                'error' => 'Mahasiswa tidak ditemukan.'
            ]);
        }

        // Cari data KHS terbaru
        $khs = KHS::join('Mahasiswa', 'KHS.id_mhs', '=', 'Mahasiswa.id_mhs')
            ->where('KHS.id_mhs', $id_mhs)
            ->orderBy('KHS.id_khs', 'desc')
            ->select('KHS.*')
            ->first();

        $khsExist = $khs ? true : false;

        return view('mahasiswa.khs', compact('mahasiswa', 'khs', 'khsExist'));
    }


    public function createkhs($id_mhs, Request $request)
    {
        $request->validate([
            'smt_aktif' => 'required|numeric',
            'SKS_semester' => 'required|numeric',
            'IP_smt' => 'required|numeric',
            'IP_kumulatif' => 'required|numeric',
            'berkas_khs' => 'required|file|mimes:pdf|max:10000'
        ], [
            'smt_aktif.required' => 'Semester Aktif wajib diisi!',
            'smt_aktif.numeric' => 'Semester Aktif harus berupa angka!',
            'SKS_semester.required' => 'Jumlah SKS Semester wajib diisi!',
            'SKS_semester.numeric' => 'Jumlah SKS Semester harus berupa angka!',
            'IP_smt.required' => 'IP Semester wajib diisi!',
            'IP_smt.numeric' => 'IP Semester harus berupa angka!',
            'IP_kumulatif.required' => 'IP Kumulatif wajib diisi!',
            'IP_kumulatif.numeric' => 'IP Kumulatif harus berupa angka!',
            'berkas_khs.required' => 'Berkas KHS wajib diisi!',
            'berkas_khs.file' => 'Berkas KHS harus berupa file!',
            'berkas_khs.mimes' => 'Berkas KHS harus berupa file PDF!',

        ]);

        // Ambil SKS kumulatif sebelumnya jika ada
        $sks_kumulatif_sebelumnya = KHS::where('id_mhs', $id_mhs)->value('SKS_kumulatif') ?? 0;

        // Buat objek KHS baru
        $khs = new KHS();
        $khs->smt_aktif = $request->input('smt_aktif');
        $khs->SKS_semester = $request->input('SKS_semester');
        $khs->SKS_kumulatif = $sks_kumulatif_sebelumnya + $request->input('SKS_semester'); // Hitung SKS kumulatif
        $khs->IP_smt = $request->input('IP_smt');
        $khs->IP_kumulatif = $request->input('IP_kumulatif');
        $khs->status_khs = 'Terisi';
        $khs->id_mhs = $id_mhs;

        if ($request->hasFile('berkas_khs')) {
            $request->file('berkas_khs')->move('berkasKHS/', $request->file('berkas_khs')->getClientOriginalName());
            $khs->berkas_khs = $request->file('berkas_khs')->getClientOriginalName();
        }
        $khs->save();

        return redirect()->route('mahasiswa.dashboard')->with([
            'success' => 'Data KHS berhasil dibuat',
        ]);
    }

    public function entrypkl($id_mhs)
    {
        $mahasiswa = Mahasiswa::find($id_mhs);

        $irs = IRS::where('id_mhs', $id_mhs)->orderBy('id_mhs', 'desc')->first();

        if ($irs && $irs->smst_aktif < 5) {
            // Jika IRS.smst_aktif kurang dari 5 maka pesan error
            return redirect()->route('mahasiswa.dashboard')->with([
                'errors' => 'Belum dapat entry data PKL!',
            ]);
        }

        $pkl = PKL::join('Mahasiswa', 'PKL.id_mhs', '=', 'Mahasiswa.id_mhs')
        ->where('PKL.id_mhs', $id_mhs)
        ->orderBy('PKL.id_pkl', 'desc')
        ->select('PKL.*')
        ->first();

        $pklExist = $pkl ? true : false;

        return view('mahasiswa.pkl', compact('mahasiswa', 'pkl', 'pklExist'));
    }


    public function createpkl($id_mhs, Request $request)
    {

        $request->validate([
            'nilai_pkl' => 'required',
            'berkas_pkl' => 'required|file|mimes:pdf|max:10000'
        ], [
            'nilai_pkl.required' => 'Nilai PKL wajib diisi!',
            'berkas_pkl.required' => 'Berkas PKL wajib diisi!',
            'berkas_pkl.file' => 'Berkas PKL harus berupa file!',
            'berkas_pkl.mimes' => 'Berkas PKL harus berupa file PDF!',
        ]);

        $pkl = new PKL();
        $pkl->nilai_pkl = $request->input('nilai_pkl');
        $pkl->id_mhs = $id_mhs;
        $pkl->status_pkl = 'Sudah PKL';
        $pkl->id_mhs = $id_mhs;

        if ($request->hasFile('berkas_pkl')) {
            $request->file('berkas_pkl')->move('berkasPKL/', $request->file('berkas_pkl')->getClientOriginalName());
            $pkl->berkas_pkl = $request->file('berkas_pkl')->getClientOriginalName();
        }

        $pkl->save();

        return redirect()->route('mahasiswa.dashboard')->with([
            'success' => 'Data PKL berhasil dibuat',
        ]);
    }

    public function entryskripsi($id_mhs)
    {
        $mahasiswa = Mahasiswa::find($id_mhs);

        $irs = IRS::where('id_mhs', $id_mhs)->orderBy('id_mhs', 'desc')->first();

        if ($irs && $irs->smst_aktif < 7) {
            // Jika IRS.smst_aktif kurang dari 7 maka pesan error
            return redirect()->route('mahasiswa.dashboard')->with([
                'errors' => 'Belum dapat entry data Skripsi!',
            ]);
        }

        $skripsi = Skripsi::join('Mahasiswa', 'Skripsi.id_mhs', '=', 'Mahasiswa.id_mhs')
            ->join('IRS', 'IRS.id_mhs', '=', 'Mahasiswa.id_mhs')
            ->where('Skripsi.id_mhs', $id_mhs)
            ->orderBy('Skripsi.id_skripsi', 'desc')
            ->select('Skripsi.*')
            ->first();

        $skripsiExist = $skripsi ? true : false;

        return view('mahasiswa.skripsi', compact('mahasiswa', 'skripsi', 'skripsiExist'));
    }



    public function createSkripsi($id_mhs, Request $request)
    {
        $request->validate([
            'nilai_skripsi' => 'required|numeric',
            'lama_studi' => 'required|numeric',
            'tanggal_sidang' => 'required|date',
            'berkas_skripsi' => 'required|file|mimes:pdf|max:10000'
        ], [
            'nilai_skripsi.required' => 'Nilai Skripsi wajib diisi!',
            'nilai_skripsi.numeric' => 'Nilai Skripsi harus berupa angka!',
            'lama_studi.required' => 'Lama Studi wajib diisi!',
            'lama_studi.numeric' => 'Lama Studi harus berupa angka!',
            'tanggal_sidang.required' => 'Tanggal Sidang wajib diisi!',
            'tanggal_sidang.date' => 'Tanggal Sidang harus berupa tanggal!',
            'berkas_skripsi.required' => 'Berkas Skripsi wajib diisi!',
            'berkas_skripsi.file' => 'Berkas Skripsi harus berupa file!',
            'berkas_skripsi.mimes' => 'Berkas Skripsi harus berupa file PDF!',
        ]);

        // Membuat objek Skripsi
        $skripsi = new Skripsi();

        // Mengisi nilai-nilai Skripsi
        $skripsi->nilai_skripsi = $request->input('nilai_skripsi');
        $skripsi->tanggal_sidang = $request->input('tanggal_sidang');
        $skripsi->status_skripsi = 'Sudah Skripsi';
        $skripsi->id_mhs = $id_mhs;

        // Mencari IRS terkait dari mahasiswa
        $irs = IRS::where('id_mhs', $id_mhs)->orderBy('IRS.id_irs', 'desc')->first();

        // Menambahkan nilai smst_aktif ke lama_studi dari IRS
        if ($irs) {
            $skripsi->lama_studi = $irs->smst_aktif;
        }

        if ($request->hasFile('berkas_skripsi')) {
            $request->file('berkas_skripsi')->move('berkasSkripsi/', $request->file('berkas_skripsi')->getClientOriginalName());
            $skripsi->berkas_skripsi = $request->file('berkas_skripsi')->getClientOriginalName();
        }

        // Simpan Skripsi ke database
        $skripsi->save();

        return redirect()->route('mahasiswa.dashboard')->with([
            'success' => 'Data Skripsi berhasil dibuat',
        ]);
    }

    

}
