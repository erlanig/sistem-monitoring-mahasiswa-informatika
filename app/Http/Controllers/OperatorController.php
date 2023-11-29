<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Models\Kota;
use App\Models\Mahasiswa;
use App\Models\Operator;
use App\Models\Departemen;
use App\Models\User;
use App\Models\Dosen;
use App\Models\IRS;
use App\Models\KHS;
use App\Models\PKL;
use App\Models\Skripsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\FlareClient\View;
use Illuminate\Support\Facades\Hash;

class OperatorController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $nip = Operator::where('email', $user->email)->value('NIP');
        $operator = Operator::where('Operator.email', $user->email)
        ->leftJoin('Users', 'Operator.email', '=', 'Users.email')
        ->select('operator.*')
        ->first();

        $jumlahMahasiswa = DB::table('Mahasiswa')
        ->select('Mahasiswa.id_mhs')
        ->distinct()
        ->count();    

        $jumlahMahasiswaIRS = DB::table('Mahasiswa')
        ->leftJoin('IRS', 'Mahasiswa.id_mhs', '=', 'IRS.id_mhs')
        ->where('IRS.status_irs', 'Terisi')
        ->where('IRS.persetujuan', 'Disetujui')
        ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
        ->count();

        $jumlahMahasiswaBlmIRS = DB::table('Mahasiswa')
        ->leftJoin('IRS', 'Mahasiswa.id_mhs', '=', 'IRS.id_mhs')
        ->where('IRS.status_irs', 'Belum Terisi')
        ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
        ->count();

        $totalpersenIRS = ($jumlahMahasiswaIRS/$jumlahMahasiswa) * 100;
        $totalpersenBlmIRS = ($jumlahMahasiswaBlmIRS/$jumlahMahasiswa) * 100;

        $jumlahMahasiswaKHS = DB::table('Mahasiswa')
        ->leftJoin('KHS', 'Mahasiswa.id_mhs', '=', 'KHS.id_mhs')
        ->where('KHS.status_khs', 'Sudah KHS')
        ->where('KHS.persetujuan', 'Disetujui')
        ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
        ->count();

        $jumlahMahasiswaBlmKHS = DB::table('Mahasiswa')
        ->leftJoin('KHS', 'Mahasiswa.id_mhs', '=', 'KHS.id_mhs')
        ->where('KHS.status_khs', 'Belum KHS')
        ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
        ->count();

        $totalpersenKHS = ($jumlahMahasiswaKHS/$jumlahMahasiswa) * 100;
        $totalpersenBlmKHS = ($jumlahMahasiswaBlmKHS/$jumlahMahasiswa) * 100;

        $jumlahMahasiswaPKL = DB::table('Mahasiswa')
        ->leftJoin('PKL', 'Mahasiswa.id_mhs', '=', 'PKL.id_mhs')
        ->where('PKL.status_pkl', 'Sudah PKL')
        ->where('PKL.persetujuan', 'Disetujui')
        ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
        ->count();

        $jumlahMahasiswaBlmPKL = DB::table('Mahasiswa')
        ->leftJoin('PKL', 'Mahasiswa.id_mhs', '=', 'PKL.id_mhs')
        ->where('PKL.status_pkl', 'Belum PKL')
        ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
        ->count();

        $totalPersenPKL = ($jumlahMahasiswaPKL/$jumlahMahasiswa) * 100;
        $totalPersenBlmPKL = ($jumlahMahasiswaBlmPKL/$jumlahMahasiswa) * 100;

        $jumlahMahasiswaSkripsi = DB::table('Mahasiswa')
        ->leftJoin('Skripsi', 'Mahasiswa.id_mhs', '=', 'Skripsi.id_mhs')
        ->where('Skripsi.status_skripsi', 'Sudah Skripsi')
        ->where('Skripsi.persetujuan', 'Disetujui')
        ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
        ->count();

        $jumlahMahasiswaBlmSkripsi = DB::table('Mahasiswa')
        ->leftJoin('Skripsi', 'Mahasiswa.id_mhs', '=', 'Skripsi.id_mhs')
        ->where('Skripsi.status_skripsi', 'Belum Skripsi')
        ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
        ->count();

        $totalPersenSkripsi = ($jumlahMahasiswaSkripsi/$jumlahMahasiswa) * 100;
        $totalPersenBlmSkripsi = ($jumlahMahasiswaBlmSkripsi/$jumlahMahasiswa) * 100;

        $jumlahMahasiswaAktif = DB::table('Mahasiswa')
        ->where('Mahasiswa.status', 'AKTIF')
        ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
        ->count();    

        $statusTidakAktif = ['TIDAK AKTIF', 'CUTI', 'MANGKIR', 'DO', 'UNDUR DIRI', 'LULUS', 'MENINGGAL DUNIA'];

        $jumlahMahasiswaTidakAktif = DB::table('Mahasiswa')
        ->whereIn('Mahasiswa.status', $statusTidakAktif)
        ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
        ->count();

        $status = ['AKTIF', 'TIDAK AKTIF', 'CUTI', 'MANGKIR', 'DO', 'UNDUR DIRI', 'LULUS', 'MENINGGAL DUNIA'];

        $cekStatusMahasiswa = DB::table('Mahasiswa')
        ->whereIn('Mahasiswa.status', $status) 
        ->get();
    
        $jumlahStatus = [];
        foreach ($status as $status) {
            $count = $cekStatusMahasiswa->where('status', $status)->count();
            $jumlahStatus[$status] = $count;
        }


        return view('operator.dashboard', compact('operator', 'jumlahMahasiswaPKL', 'totalPersenPKL', 'jumlahMahasiswa', 'jumlahMahasiswaBlmPKL', 'totalPersenBlmPKL',
    'jumlahMahasiswaIRS', 'jumlahMahasiswaBlmIRS', 'totalpersenIRS', 'totalpersenBlmIRS',
    'jumlahMahasiswaKHS', 'jumlahMahasiswaBlmKHS', 'totalpersenKHS', 'totalpersenBlmKHS',
    'jumlahMahasiswaSkripsi', 'jumlahMahasiswaBlmSkripsi', 'totalPersenSkripsi', 'totalPersenBlmSkripsi',
    'jumlahMahasiswaAktif','jumlahMahasiswaTidakAktif', 'jumlahStatus'));
    }

    public function manajemenakun()
    {
        $user = auth()->user();
        $nip = Operator::where('email', $user->email)->value('NIP');
        $operator = Operator::where('Operator.email', $user->email)
        ->select('operator.*')
        ->first();

        $mahasiswa = Mahasiswa::select('NIM', 'Nama')
        ->get();

        return view('operator.manajemen', compact('operator', 'mahasiswa'));

    }

    public function generate()
    {
        $user = auth()->user();
        $nip = Operator::where('email', $user->email)->value('NIP');
        $operator = Operator::where('Operator.email', $user->email)
        ->select('operator.*')
        ->first();

        $users = User::get();

        return view('operator.generate', compact('users','operator'));
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function import()
    {
        Excel::import(new UsersImport,request()->file('file'));
        return back();
    }

    public function create()
    {
        $user = auth()->user();
        $nip = Operator::where('email', $user->email)->value('NIP');
        $operator = Operator::where('Operator.email', $user->email)
        ->leftJoin('Users', 'Operator.email', '=', 'Users.email')
        ->select('operator.*')
        ->first();

        return View('operator.create', compact('operator'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'nim' => 'required',
            'fakultas' => 'required',
            'angkatan' => 'required',
            'status' => 'required',
            'jalur_masuk' => 'required',
            'nama_doswal' => 'required',
        ]);

        // Simpan data ke tabel users
        $user = new User;
        $user->nama = $request->input('nama');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        // Simpan data ke tabel mahasiswa
        $mahasiswa = new Mahasiswa;
        $mahasiswa->NIM = $request->input('nim');
        $mahasiswa->nama = $request->input('nama');
        $mahasiswa->email = $request->input('email');
        $mahasiswa->fakultas = $request->input('fakultas');
        $mahasiswa->angkatan = $request->input('angkatan');
        $mahasiswa->status = $request->input('status');
        $mahasiswa->jalur_masuk = $request->input('jalur_masuk');
        $mahasiswa->nama_doswal = $request->input('nama_doswal');
        $mahasiswa->save();

        // Redirect atau tampilkan pesan sukses
        return redirect()->route('operator.create')->with('success', 'Data Mahasiswa berhasil disimpan.');
    }

    public function edit($NIM)
    {
        $user = auth()->user();
        $nip = Operator::where('email', $user->email)->value('NIP');
        $operator = Operator::where('Operator.email', $user->email)
        ->leftJoin('Users', 'Operator.email', '=', 'Users.email')
        ->select('operator.*')
        ->first();

        $mahasiswa = Mahasiswa::where('NIM', $NIM)->first();
        if (!$mahasiswa) {
            
            return redirect()->route('operator.manajemen')->with('error', 'Mahasiswa tidak ditemukan');
        }

        $kota = Kota::join('Provinsi', 'Kota_Kab.kode_prov', '=', 'Provinsi.kode_prov')
            ->select('Kota_Kab.kode_kota_kab', 'Kota_Kab.nama_kota_kab AS namakota', 'Provinsi.nama_prov AS namaprov')
            ->get();

        return view('operator.edit', compact('operator', 'mahasiswa', 'kota'));
    }

    public function update($NIM, Request $request)
    {
        $mahasiswa = Mahasiswa::where('NIM', $NIM)->first();
        if (!$mahasiswa) {
            // Handle jika mahasiswa tidak ditemukan
            return redirect()->route('operator.manajemen')->with('error', 'Mahasiswa tidak ditemukan');
        }

        // Validasi input
        $validatedData = $request->validate([
            'nama' => 'required|string|max:50',
            'email' => 'required|email|max:50',
            'alamat' => 'required|string|max:50',
            'no_HP' => 'required|string|max:15',
            'angkatan' => 'required|string|max:4',
            'status' => 'required|string|max:15',
            'jalur_masuk' => 'required|string|max:10',
            'kode_kota_kab' => 'string|max:4',
            'password' => 'nullable|min:6|confirmed',
        ]);

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


        return redirect()->route('operator.manajemen')->with('success', 'Data mahasiswa berhasil diperbarui');
    }

    public function rekappkl()
    {
    $user = auth()->user();
    $nip = Operator::where('email', $user->email)->value('NIP');

    $operator = Operator::where('Operator.email', $user->email)
    ->select('Operator.*')
    ->first();

    $tahun = DB::table('Mahasiswa')
    ->select('angkatan')
    ->distinct()
    ->orderBy('angkatan', 'asc') 
    ->pluck('angkatan')
    ->toArray();

    $jumlahAngkatan = count($tahun);

    $jumlahMahasiswaPKL = [];
    $jumlahMahasiswaBLMPKL = [];

    foreach ($tahun as $year) {
        $jumlahMahasiswaPKL[$year] = PKL::join('Mahasiswa', 'PKL.id_mhs', '=', 'Mahasiswa.id_mhs')
        ->where('Mahasiswa.angkatan', $year)
        ->where('PKL.status_pkl', 'Sudah PKL')
        ->where('PKL.persetujuan', 'Disetujui')
        ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
        ->count();

        $jumlahMahasiswaBlmPKL[$year] = DB::table('Mahasiswa')
        ->leftJoin('PKL', 'Mahasiswa.id_mhs', '=', 'PKL.id_mhs')
        ->where('PKL.status_pkl', 'Belum PKL')
        ->where('Mahasiswa.angkatan', $year)
        ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
        ->count();
    }

    return view('operator.rekapPKL', compact('operator', 'jumlahMahasiswaPKL', 'jumlahMahasiswaBlmPKL', 'tahun', 'jumlahAngkatan'));
    }

    public function dataSudahPKL($tahun)
    {
        $user = auth()->user();
        $nip = Operator::where('email', $user->email)->value('NIP');

        $operator = Operator::where('Operator.email', $user->email)
        ->select('Operator.*')
        ->first();


        $doswal = Dosen::join('Mahasiswa', 'Dosen.nama_doswal', '=', 'Mahasiswa.nama_doswal')
        ->where('Mahasiswa.angkatan', $tahun)
        ->first();

        $pkl = PKL::join('Mahasiswa', 'PKL.id_mhs', '=', 'Mahasiswa.id_mhs')
        ->where('Mahasiswa.angkatan', $tahun)
        ->where('PKL.status_pkl', 'Sudah PKL')
        ->where('PKL.persetujuan', 'Disetujui')
        ->select('pkl.*', 'mahasiswa.NIM as NIM', 'mahasiswa.nama as nama', 'mahasiswa.angkatan as angkatan', 'mahasiswa.nama_doswal as nama_doswal')
        ->get();
    
        return view('operator.sudahpkl', compact('operator', 'pkl', 'tahun','doswal'));
    }

    public function dataBlmPKL($tahun)
    {
        $user = auth()->user();
        $nip = Operator::where('email', $user->email)->value('NIP');

        $operator = Operator::where('Operator.email', $user->email)
        ->select('Operator.*')
        ->first();

        $doswal = Dosen::join('Mahasiswa', 'Dosen.nama_doswal', '=', 'Mahasiswa.nama_doswal')
        ->where('Mahasiswa.angkatan', $tahun)
        ->first();

        $pkl = PKL::join('Mahasiswa', 'PKL.id_mhs', '=', 'Mahasiswa.id_mhs')
        ->where('Mahasiswa.angkatan', $tahun)
        ->where('PKL.status_pkl', 'Belum PKL')
        ->select('pkl.*', 'mahasiswa.NIM as NIM', 'mahasiswa.nama as nama', 'mahasiswa.angkatan as angkatan',  'mahasiswa.nama_doswal as nama_doswal')
        ->get();
    
        return view('operator.belumpkl', compact('operator', 'pkl','tahun','doswal'));
    }

    public function cetakPKL()
    {    
        $pkl = PKL::join('Mahasiswa', 'PKL.id_mhs', '=', 'Mahasiswa.id_mhs')
            ->select('pkl.*', 'mahasiswa.NIM as NIM', 'mahasiswa.nama as nama', 'mahasiswa.angkatan as angkatan',  'mahasiswa.nama_doswal as nama_doswal')
            //->where('PKL.persetujuan', 'Disetujui')
            ->get();
    
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('operator.cetakrekappkl', ['pkl' => $pkl]);
    
        return $pdf->stream('rekap-pkl.pdf');
    }

    public function cetakSudahPKL($tahun)
    {
        $doswal = Dosen::join('Mahasiswa', 'Dosen.nama_doswal', '=', 'Mahasiswa.nama_doswal')
        ->where('Mahasiswa.angkatan', $tahun)
        ->first();

        $pkl = PKL::join('Mahasiswa', 'PKL.id_mhs', '=', 'Mahasiswa.id_mhs')
            ->where('Mahasiswa.angkatan', $tahun)
            ->where('PKL.status_pkl', 'Sudah PKL')
            ->where('PKL.persetujuan', 'Disetujui')
            ->select('pkl.*', 'mahasiswa.NIM as NIM', 'mahasiswa.nama as nama', 'mahasiswa.angkatan as angkatan')
            ->get();
    
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('operator.cetaksudahpkl', ['pkl' => $pkl, 'tahun' => $tahun, 'doswal' => $doswal]);
    
        return $pdf->stream('sudah-pkl' . $tahun . '.pdf');
    }
    
    public function cetakBelumPKL($tahun)
    {
        $doswal = Dosen::join('Mahasiswa', 'Dosen.nama_doswal', '=', 'Mahasiswa.nama_doswal')
        ->where('Mahasiswa.angkatan', $tahun)
        ->first();

        $pkl = PKL::join('Mahasiswa', 'PKL.id_mhs', '=', 'Mahasiswa.id_mhs')
            ->where('Mahasiswa.angkatan', $tahun)
            ->where('PKL.status_pkl', 'Belum PKL')
            ->select('pkl.*', 'mahasiswa.NIM as NIM', 'mahasiswa.nama as nama', 'mahasiswa.angkatan as angkatan')
            ->get();
    
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('operator.cetakbelumpkl', ['pkl' => $pkl, 'tahun' => $tahun, 'doswal' => $doswal]);
    
        return $pdf->stream('belum-pkl' . $tahun . '.pdf');
    }
    
    // Skripsi
    public function rekapskripsi()
    {
    $user = auth()->user();
    $nip = Operator::where('email', $user->email)->value('NIP');

    $operator = Operator::where('Operator.email', $user->email)
    ->select('Operator.*')
    ->first();

    $tahun = DB::table('Mahasiswa')
    ->select('angkatan')
    ->distinct()
    ->orderBy('angkatan', 'asc') 
    ->pluck('angkatan')
    ->toArray();

    $jumlahAngkatan = count($tahun);

    $jumlahMahasiswaSkripsi = [];
    $jumlahMahasiswaBlmSkripsi = [];

    foreach ($tahun as $year) {
        $jumlahMahasiswaSkripsi[$year] = Skripsi::join('Mahasiswa', 'Skripsi.id_mhs', '=', 'Mahasiswa.id_mhs')
        ->where('Mahasiswa.angkatan', $year)
        ->where('Skripsi.status_skripsi', 'Sudah Skripsi')
        ->where('Skripsi.persetujuan', 'Disetujui')
        ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
        ->count();

        $jumlahMahasiswaBlmSkripsi[$year] = DB::table('Mahasiswa')
        ->leftJoin('Skripsi', 'Mahasiswa.id_mhs', '=', 'Skripsi.id_mhs')
        ->where('Skripsi.status_skripsi', 'Belum Skripsi')
        ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
        ->where('Mahasiswa.angkatan', $year)
        ->count();
    }

    return view('operator.rekapSkripsi', compact('operator', 'jumlahMahasiswaSkripsi', 'jumlahMahasiswaBlmSkripsi', 'tahun', 'jumlahAngkatan'));
    }
        
    public function dataSudahSkripsi($tahun)
    {
        $user = auth()->user();
        $nip = Operator::where('email', $user->email)->value('NIP');

        $operator = Operator::where('Operator.email', $user->email)
        ->select('Operator.*')
        ->first();

        $doswal = Dosen::join('Mahasiswa', 'Dosen.nama_doswal', '=', 'Mahasiswa.nama_doswal')
        ->where('Mahasiswa.angkatan', $tahun)
        ->first();

        $skripsi = Skripsi::join('Mahasiswa', 'Skripsi.id_mhs', '=', 'Mahasiswa.id_mhs')
        ->where('Mahasiswa.angkatan', $tahun)
        ->where('Skripsi.status_skripsi', 'Sudah Skripsi')
        ->where('Skripsi.persetujuan', 'Disetujui')
        ->select('Skripsi.*', 'mahasiswa.NIM as NIM', 'mahasiswa.nama as nama', 'mahasiswa.angkatan as angkatan')
        ->get();
    
        return view('operator.sudahSkripsi', compact('operator', 'skripsi', 'tahun', 'doswal'));
    }

    public function dataBlmSkripsi($tahun)
    {
        $user = auth()->user();
        $nip = Operator::where('email', $user->email)->value('NIP');

        $operator = Operator::where('Operator.email', $user->email)
        ->select('Operator.*')
        ->first();

        $doswal = Dosen::join('Mahasiswa', 'Dosen.nama_doswal', '=', 'Mahasiswa.nama_doswal')
        ->where('Mahasiswa.angkatan', $tahun)
        ->first();

        $skripsi = Skripsi::join('Mahasiswa', 'Skripsi.id_mhs', '=', 'Mahasiswa.id_mhs')
        ->where('Mahasiswa.angkatan', $tahun)
        ->where('Skripsi.status_skripsi', 'Belum Skripsi')
        ->select('Skripsi.*', 'mahasiswa.NIM as NIM', 'mahasiswa.nama as nama', 'mahasiswa.angkatan as angkatan')
        ->get();
    
        return view('operator.belumSkripsi', compact('operator', 'skripsi', 'tahun', 'doswal'));
    }

    public function cetakSkripsi()
    {    
        $skripsi = Skripsi::join('Mahasiswa', 'Skripsi.id_mhs', '=', 'Mahasiswa.id_mhs')
            ->select('Skripsi.*', 'mahasiswa.NIM as NIM', 'mahasiswa.nama as nama', 'mahasiswa.angkatan as angkatan')
            ->get();
    
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('operator.cetakrekapskripsi', ['skripsi' => $skripsi]);
    
        return $pdf->stream('rekap-skripsi.pdf');
    }

    public function cetakSudahSkripsi($tahun)
    {
        $doswal = Dosen::join('Mahasiswa', 'Dosen.nama_doswal', '=', 'Mahasiswa.nama_doswal')
        ->where('Mahasiswa.angkatan', $tahun)
        ->first();

        $skripsi = Skripsi::join('Mahasiswa', 'Skripsi.id_mhs', '=', 'Mahasiswa.id_mhs')
            ->where('Mahasiswa.angkatan', $tahun)
            ->where('Skripsi.status_skripsi', 'Sudah Skripsi')
            ->where('Skripsi.persetujuan', 'Disetujui')
            ->select('Skripsi.*', 'mahasiswa.NIM as NIM', 'mahasiswa.nama as nama', 'mahasiswa.angkatan as angkatan')
            ->get();
    
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('operator.cetaksudahskripsi', ['skripsi' => $skripsi, 'tahun' => $tahun, 'doswal' => $doswal]);
    
        return $pdf->stream('sudah-skripsi' . $tahun . '.pdf');
    }
    

    public function cetakBelumSkripsi($tahun)
    {
        $doswal = Dosen::join('Mahasiswa', 'Dosen.nama_doswal', '=', 'Mahasiswa.nama_doswal')
        ->where('Mahasiswa.angkatan', $tahun)
        ->first();

        $skripsi = Skripsi::join('Mahasiswa', 'Skripsi.id_mhs', '=', 'Mahasiswa.id_mhs')
            ->where('Mahasiswa.angkatan', $tahun)
            ->where('Skripsi.status_skripsi', 'Belum Skripsi')
            ->select('Skripsi.*', 'mahasiswa.NIM as NIM', 'mahasiswa.nama as nama', 'mahasiswa.angkatan as angkatan')
            ->get();
    
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('operator.cetakbelumskripsi', ['skripsi' => $skripsi, 'tahun' => $tahun, 'doswal' => $doswal]);
    
        return $pdf->stream('belum-skripsi' . $tahun . '.pdf');
    }

    public function rekapStatus()
    {
        $user = auth()->user();
        $nip = Operator::where('email', $user->email)->value('NIP');
    
        $operator = Operator::where('Operator.email', $user->email)
            ->select('Operator.*')
            ->first();
    
        $statusTidakAktif = ['TIDAK AKTIF', 'CUTI', 'MANGKIR', 'DO', 'UNDUR DIRI', 'LULUS', 'MENINGGAL DUNIA'];
    
        $tahun = DB::table('Mahasiswa')
            ->select('angkatan')
            ->distinct()
            ->orderBy('angkatan', 'asc')
            ->pluck('angkatan')
            ->toArray();
    
        $jumlahAngkatan = count($tahun);

        $jumlahMahasiswaAktif = [];
        $jumlahMahasiswaTidakAktif = [];
        $jumlahMahasiswaCuti = [];
        $jumlahMahasiswaMangkir = [];
        $jumlahMahasiswaDO = [];
        $jumlahMahasiswaLulus= [];
        $jumlahMahasiswaUD = [];
        $jumlahMahasiswaMD= [];
        
    
        foreach ($tahun as $year) {
            $jumlahMahasiswaAktif[$year] = DB::table('Mahasiswa')
            ->where('Mahasiswa.angkatan', $year)
            ->where('Mahasiswa.status', 'AKTIF')
            ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
            ->count();

            $jumlahMahasiswaTidakAktif[$year] = DB::table('Mahasiswa')
                ->where('Mahasiswa.angkatan', $year)
                ->where('Mahasiswa.status', 'TIDAK AKTIF')
                ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
                ->count();

            $jumlahMahasiswaCuti[$year] = DB::table('Mahasiswa')
                ->where('Mahasiswa.angkatan', $year)
                ->where('Mahasiswa.status', 'CUTI')
                ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
                ->count();
            $jumlahMahasiswaMangkir[$year] = DB::table('Mahasiswa')
                ->where('Mahasiswa.angkatan', $year)
                ->where('Mahasiswa.status', 'MANGKIR')
                ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
                ->count();
            $jumlahMahasiswaDO[$year] = DB::table('Mahasiswa')
                ->where('Mahasiswa.angkatan', $year)
                ->where('Mahasiswa.status', 'DO')
                ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
                ->count();
            $jumlahMahasiswaUD[$year] = DB::table('Mahasiswa')
                ->where('Mahasiswa.angkatan', $year)
                ->where('Mahasiswa.status', 'UNDUR DIRI')
                ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
                ->count();
            $jumlahMahasiswaLulus[$year] = DB::table('Mahasiswa')
                ->where('Mahasiswa.angkatan', $year)
                ->where('Mahasiswa.status', 'LULUS')
                ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
                ->count();
            $jumlahMahasiswaMD[$year] = DB::table('Mahasiswa')
                ->where('Mahasiswa.angkatan', $year)
                ->where('Mahasiswa.status', 'MENINGGAL DUNIA')
                ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
                ->count();
        }
    
        return view('operator.rekapstatus', compact('operator', 'jumlahMahasiswaAktif', 'jumlahMahasiswaTidakAktif', 'jumlahMahasiswaCuti', 'jumlahMahasiswaMangkir', 'jumlahMahasiswaDO', 'jumlahMahasiswaUD', 'jumlahMahasiswaLulus', 'jumlahMahasiswaMD', 'tahun', 'jumlahAngkatan'));
    }

    
    public function dataMhsAktif($tahun)
    {
        $user = auth()->user();
        $nip = Operator::where('email', $user->email)->value('NIP');
    
        $operator = Operator::where('Operator.email', $user->email)
            ->select('Operator.*')
            ->first();

        $doswal = Dosen::join('Mahasiswa', 'Dosen.nama_doswal', '=', 'Mahasiswa.nama_doswal')
        ->where('Mahasiswa.angkatan', $tahun)
        ->first();

        $aktif = DB::table('Mahasiswa')
        ->where('Mahasiswa.angkatan', $tahun)
        ->where('Mahasiswa.status', 'AKTIF')
        ->select('Mahasiswa.*')
        ->get();
    
        return view('operator.mhsaktif', compact('operator', 'aktif', 'tahun', 'doswal'));
    }

    public function dataMhsTdkAktif($tahun, $status)
    {
        $user = auth()->user();
        $nip = Operator::where('email', $user->email)->value('NIP');
    
        $operator = Operator::where('Operator.email', $user->email)
            ->select('Operator.*')
            ->first();

        $doswal = Dosen::join('Mahasiswa', 'Dosen.nama_doswal', '=', 'Mahasiswa.nama_doswal')
        ->where('Mahasiswa.angkatan', $tahun)
        ->first();


        $tdkAktif = DB::table('Mahasiswa')
        ->where('Mahasiswa.angkatan', $tahun)
        ->where('Mahasiswa.status', $status)
        ->select('Mahasiswa.*')
        ->get();
    
        return view('operator.mhstdkaktif', compact('operator', 'tdkAktif', 'tahun', 'doswal', 'status'));
    }

    public function cetakStatus()
    {    
        $status = DB::table('Mahasiswa')
            ->select('Mahasiswa.*')
            ->get();
    
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('operator.cetakrekapstatus', ['status' => $status]);
    
        return $pdf->stream('rekap-status.pdf');
    }

    public function cetakMhsAktif($tahun)
    {
        $doswal = Dosen::join('Mahasiswa', 'Dosen.nama_doswal', '=', 'Mahasiswa.nama_doswal')
        ->where('Mahasiswa.angkatan', $tahun)
        ->first();

        $aktif = DB::table('Mahasiswa')
            ->where('Mahasiswa.angkatan', $tahun)
            ->where('Mahasiswa.status', 'AKTIF')
            ->select('Mahasiswa.*')
            ->get();
    
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('operator.cetakMhsAktif', ['aktif' => $aktif, 'tahun' => $tahun, 'doswal' => $doswal]);
    
        return $pdf->stream('mahasiswa-aktif-' . $tahun . '.pdf');
    }
    
    public function cetakMhsTdkAktif($tahun, $status)
    {
        $doswal = Dosen::join('Mahasiswa', 'Dosen.nama_doswal', '=', 'Mahasiswa.nama_doswal')
        ->where('Mahasiswa.angkatan', $tahun)
        ->first();

        $tdkAktif = DB::table('Mahasiswa')
            ->where('Mahasiswa.angkatan', $tahun)
            ->where('Mahasiswa.status', $status)
            ->select('Mahasiswa.*')
            ->get();
    
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('operator.cetakMhsTdkAktif', ['tdkAktif' => $tdkAktif, 'tahun' => $tahun, 'doswal' => $doswal, 'status' => $status]);
    
        return $pdf->stream('mahasiswa-tidak-aktif-' . $tahun . '.pdf');
    }

}

