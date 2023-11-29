<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\IRS;
use App\Models\KHS;
use App\Models\PKL;
use App\Models\Skripsi;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class DepartemenController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $nip = Departemen::where('email', $user->email)->value('NIP');

        $dept = Departemen::where('Departemen.email', $user->email)
        ->select('Departemen.*')
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

        $statusTidakAktif = ['AKTIF', 'TIDAK AKTIF', 'CUTI', 'MANGKIR', 'DO', 'UNDUR DIRI', 'LULUS', 'MENINGGAL DUNIA'];

        $cekStatusMahasiswa = DB::table('Mahasiswa')
        ->whereIn('Mahasiswa.status', $statusTidakAktif) 
        ->get();
    
        $jumlahStatus = [];
        foreach ($statusTidakAktif as $status) {
            $count = $cekStatusMahasiswa->where('status', $status)->count();
            $jumlahStatus[$status] = $count;
        }


        return view('departemen.dashboard', compact('dept', 'jumlahMahasiswaPKL', 'totalPersenPKL', 'jumlahMahasiswa', 'jumlahMahasiswaBlmPKL', 'totalPersenBlmPKL',
    'jumlahMahasiswaIRS', 'jumlahMahasiswaBlmIRS', 'totalpersenIRS', 'totalpersenBlmIRS',
    'jumlahMahasiswaKHS', 'jumlahMahasiswaBlmKHS', 'totalpersenKHS', 'totalpersenBlmKHS',
    'jumlahMahasiswaSkripsi', 'jumlahMahasiswaBlmSkripsi', 'totalPersenSkripsi', 'totalPersenBlmSkripsi',
    'jumlahMahasiswaAktif','jumlahMahasiswaTidakAktif', 'jumlahStatus'));
    }

    public function rekapirs()
    {
    $user = auth()->user();
    $nip = Departemen::where('email', $user->email)->value('NIP');

    $dept = Departemen::where('Departemen.email', $user->email)
    ->select('Departemen.*')
    ->first();

    $years = range(2020, 2023);
    $jumlahMahasiswaIRS = [];
    $jumlahMahasiswaBlmIRS = [];

    foreach ($years as $year) {
        $jumlahMahasiswaIRS[$year] = DB::table('Mahasiswa')
        ->join('Departemen', 'Mahasiswa.fakultas', '=', 'Departemen.fakultas')
        ->leftJoin('IRS', 'Mahasiswa.id_mhs', '=', 'IRS.id_mhs')
        ->where('IRS.status_irs', 'Terisi')
        ->where('Mahasiswa.angkatan', $year)
        ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
        ->count();

        $jumlahMahasiswaBlmIRS[$year] = DB::table('Mahasiswa')
        ->join('Departemen', 'Mahasiswa.fakultas', '=', 'Departemen.fakultas')
        ->leftJoin('IRS', 'Mahasiswa.id_mhs', '=', 'IRS.id_mhs')
        ->where('IRS.status_irs', 'Belum Terisi')
        ->where('Mahasiswa.angkatan', $year)
        ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
        ->count();
    }

    return view('departemen.rekapIRS', compact('dept', 'jumlahMahasiswaIRS', 'jumlahMahasiswaBlmIRS', 'years'));
}

    public function dataSudahIRS($tahun)
    {
        $user = auth()->user();
        $nip = Departemen::where('email', $user->email)->value('NIP');

        $dept = Departemen::where('Departemen.email', $user->email)
        ->select('Departemen.*')
        ->first();

        $irs = IRS::join('Mahasiswa', 'IRS.id_mhs', '=', 'Mahasiswa.id_mhs')
        ->where('Mahasiswa.angkatan', $tahun)
        ->where('IRS.status_irs', 'Terisi')
        ->select('irs.*', 'mahasiswa.NIM as NIM', 'mahasiswa.nama as nama', 'mahasiswa.angkatan as angkatan')
        ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
        ->get();
    
        return view('departemen.sudahirs', compact('dept', 'irs'));
    }
    public function dataBlmIRS($tahun)
    {
        $user = auth()->user();
        $nip = Departemen::where('email', $user->email)->value('NIP');

        $dept = Departemen::where('Departemen.email', $user->email)
        ->select('Departemen.*')
        ->first();

        $irs = IRS::join('Mahasiswa', 'IRS.id_mhs', '=', 'Mahasiswa.id_mhs')
        ->where('Mahasiswa.angkatan', $tahun)
        ->where('IRS.status_irs', 'Belum Terisi')
        ->select('irs.*', 'mahasiswa.NIM as NIM', 'mahasiswa.nama as nama', 'mahasiswa.angkatan as angkatan')
        ->get();
    
        return view('departemen.belumirs', compact('dept', 'irs'));
    }

    public function rekappkl()
    {
    $user = auth()->user();
    $nip = Departemen::where('email', $user->email)->value('NIP');

    $dept = Departemen::where('Departemen.email', $user->email)
    ->select('Departemen.*')
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

    return view('departemen.rekapPKL', compact('dept', 'jumlahMahasiswaPKL', 'jumlahMahasiswaBlmPKL', 'tahun', 'jumlahAngkatan'));
    }

    // public function rekappkl()
    // {
    //     $user = auth()->user();
    //     $nip = Departemen::where('email', $user->email)->value('NIP');

    //     $dept = Departemen::where('Departemen.email', $user->email)
    //         ->select('Departemen.*')
    //         ->first();

    //     $tahun = range(2020, 2023);
    //     $ddoswal = ['Dr. Aris Puji Widodo, S.Si, M.T', 'Dinar Mutiara K N, S.T., M.InfoTech.(Comp)., Ph.D.', 'Adhe Setya Pramayoga, S.Kom., M.T.', 'Setya Pramayoga, S.Kom., M.T.']; // Ganti dengan nama doswal yang sesuai

    //     $dataDoswal = [];

    //     foreach ($ddoswal as $doswal) {
    //         $jumlahMahasiswaPKL = [];
    //         $jumlahMahasiswaBlmPKL = [];

    //         foreach ($tahun as $year) {
    //             $jumlahMahasiswaPKL[$year] = PKL::join('Mahasiswa', 'PKL.id_mhs', '=', 'Mahasiswa.id_mhs')
    //                 ->where('Mahasiswa.nama_doswal', $doswal)
    //                 ->where('Mahasiswa.angkatan', $year)
    //                 ->where('PKL.status_pkl', 'Sudah PKL')
    //                 ->where('PKL.persetujuan', 'Disetujui')
    //                 ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
    //                 ->count();

    //             $jumlahMahasiswaBlmPKL[$year] = DB::table('Mahasiswa')
    //                 ->leftJoin('PKL', 'Mahasiswa.id_mhs', '=', 'PKL.id_mhs')
    //                 ->where('Mahasiswa.nama_doswal', $doswal)
    //                 ->where('PKL.status_pkl', 'Belum PKL')
    //                 ->where('Mahasiswa.angkatan', $year)
    //                 ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
    //                 ->count();
    //         }

    //     }

    //     return view('departemen.rekapPKL', compact('dept', 'tahun', 'doswal', 'jumlahMahasiswaPKL', 'jumlahMahasiswaBlmPKL'));
    // }


    public function dataSudahPKL($tahun)
    {
        $user = auth()->user();
        $nip = Departemen::where('email', $user->email)->value('NIP');

        $dept = Departemen::where('Departemen.email', $user->email)
        ->select('Departemen.*')
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
    
        return view('departemen.sudahpkl', compact('dept', 'pkl', 'tahun','doswal'));
    }

    public function dataBlmPKL($tahun)
    {
        $user = auth()->user();
        $nip = Departemen::where('email', $user->email)->value('NIP');

        $dept = Departemen::where('Departemen.email', $user->email)
        ->select('Departemen.*')
        ->first();

        $doswal = Dosen::join('Mahasiswa', 'Dosen.nama_doswal', '=', 'Mahasiswa.nama_doswal')
        ->where('Mahasiswa.angkatan', $tahun)
        ->first();

        $pkl = PKL::join('Mahasiswa', 'PKL.id_mhs', '=', 'Mahasiswa.id_mhs')
        ->where('Mahasiswa.angkatan', $tahun)
        ->where('PKL.status_pkl', 'Belum PKL')
        ->select('pkl.*', 'mahasiswa.NIM as NIM', 'mahasiswa.nama as nama', 'mahasiswa.angkatan as angkatan',  'mahasiswa.nama_doswal as nama_doswal')
        ->get();
    
        return view('departemen.belumpkl', compact('dept', 'pkl','tahun','doswal'));
    }

    public function cetakPKL()
    {    
        $pkl = PKL::join('Mahasiswa', 'PKL.id_mhs', '=', 'Mahasiswa.id_mhs')
            ->select('pkl.*', 'mahasiswa.NIM as NIM', 'mahasiswa.nama as nama', 'mahasiswa.angkatan as angkatan',  'mahasiswa.nama_doswal as nama_doswal')
            //->where('PKL.persetujuan', 'Disetujui')
            ->get();
    
        $pdf = PDF::loadView('departemen.cetakrekappkl', ['pkl' => $pkl]);
    
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
    
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('departemen.cetaksudahpkl', ['pkl' => $pkl, 'tahun' => $tahun, 'doswal' => $doswal]);
    
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
    
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('departemen.cetakbelumpkl', ['pkl' => $pkl, 'tahun' => $tahun, 'doswal' => $doswal]);
    
        return $pdf->stream('belum-pkl' . $tahun . '.pdf');
    }
    
    // Skripsi
    public function rekapskripsi()
    {
    $user = auth()->user();
    $nip = Departemen::where('email', $user->email)->value('NIP');

    $dept = Departemen::where('Departemen.email', $user->email)
    ->select('Departemen.*')
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

    return view('departemen.rekapSkripsi', compact('dept', 'jumlahMahasiswaSkripsi', 'jumlahMahasiswaBlmSkripsi', 'tahun', 'jumlahAngkatan'));
    }
        
    public function dataSudahSkripsi($tahun)
    {
        $user = auth()->user();
        $nip = Departemen::where('email', $user->email)->value('NIP');

        $dept = Departemen::where('Departemen.email', $user->email)
        ->select('Departemen.*')
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
    
        return view('departemen.sudahSkripsi', compact('dept', 'skripsi', 'tahun', 'doswal'));
    }

    public function dataBlmSkripsi($tahun)
    {
        $user = auth()->user();
        $nip = Departemen::where('email', $user->email)->value('NIP');

        $dept = Departemen::where('Departemen.email', $user->email)
        ->select('Departemen.*')
        ->first();

        $doswal = Dosen::join('Mahasiswa', 'Dosen.nama_doswal', '=', 'Mahasiswa.nama_doswal')
        ->where('Mahasiswa.angkatan', $tahun)
        ->first();

        $skripsi = Skripsi::join('Mahasiswa', 'Skripsi.id_mhs', '=', 'Mahasiswa.id_mhs')
        ->where('Mahasiswa.angkatan', $tahun)
        ->where('Skripsi.status_skripsi', 'Belum Skripsi')
        ->select('Skripsi.*', 'mahasiswa.NIM as NIM', 'mahasiswa.nama as nama', 'mahasiswa.angkatan as angkatan')
        ->get();
    
        return view('departemen.belumSkripsi', compact('dept', 'skripsi', 'tahun', 'doswal'));
    }

    public function cetakSkripsi()
    {    
        $skripsi = Skripsi::join('Mahasiswa', 'Skripsi.id_mhs', '=', 'Mahasiswa.id_mhs')
            ->select('Skripsi.*', 'mahasiswa.NIM as NIM', 'mahasiswa.nama as nama', 'mahasiswa.angkatan as angkatan')
            ->get();
    
        $pdf = PDF::loadView('departemen.cetakrekapskripsi', ['skripsi' => $skripsi]);
    
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
    
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('departemen.cetaksudahskripsi', ['skripsi' => $skripsi, 'tahun' => $tahun, 'doswal' => $doswal]);
    
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
    
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('departemen.cetakbelumskripsi', ['skripsi' => $skripsi, 'tahun' => $tahun, 'doswal' => $doswal]);
    
        return $pdf->stream('belum-skripsi' . $tahun . '.pdf');
    }
    

    // public function datakhs()
    // {
    //     $user = auth()->user();
    //     $nip = Departemen::where('email', $user->email)->value('NIP');
        
    //     $dept = Departemen::where('Departemen.email', $user->email)
    //     ->select('Departemen.*')
    //     ->first();

    //     $khs = KHS::join('Mahasiswa', 'KHS.id_mhs', '=', 'Mahasiswa.id_mhs')
    //     ->select('khs.*', 'mahasiswa.NIM as NIM', 'mahasiswa.nama as nama', 'mahasiswa.angkatan as angkatan')->get();

    //     return view('departemen.KHS', compact('dept', 'khs'));
    // }

    // public function datapkl()
    // {
    //     $user = auth()->user();
    //     $nip = Departemen::where('email', $user->email)->value('NIP');
        
    //     $dept = Departemen::where('Departemen.email', $user->email)
    //     ->select('Departemen.*')
    //     ->first();

    //     $pkl = PKL::join('Mahasiswa', 'PKL.id_mhs', '=', 'Mahasiswa.id_mhs')
    //     ->select('pkl.*', 'mahasiswa.NIM as NIM', 'mahasiswa.nama as nama', 'mahasiswa.angkatan as angkatan')->get();

    //     return view('departemen.PKL', compact('dept', 'pkl'));
    // }
    
    // public function dataskripsi()
    // {
    //     $user = auth()->user();
    //     $nip = Departemen::where('email', $user->email)->value('NIP');
        
    //     $dept = Departemen::where('Departemen.email', $user->email)
    //     ->select('Departemen.*')
    //     ->first();

    //     $skripsi = Skripsi::join('Mahasiswa', 'Skripsi.id_mhs', '=', 'Mahasiswa.id_mhs')
    //     ->select('skripsi.*', 'mahasiswa.NIM as NIM', 'mahasiswa.nama as nama', 'mahasiswa.angkatan as angkatan')->get();

    //     return view('departemen.Skripsi', compact('dept', 'skripsi'));
    // }

    // Rekap Status
    public function rekapStatus(Request $request)
    {
        $user = auth()->user();
        $nip = Departemen::where('email', $user->email)->value('NIP');
    
        $dept = Departemen::where('Departemen.email', $user->email)
            ->select('Departemen.*')
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
    
        return view('departemen.rekapstatus', compact('dept', 'jumlahMahasiswaAktif', 'jumlahMahasiswaTidakAktif', 'jumlahMahasiswaCuti', 'jumlahMahasiswaMangkir', 'jumlahMahasiswaDO', 'jumlahMahasiswaUD', 'jumlahMahasiswaLulus', 'jumlahMahasiswaMD', 'tahun', 'jumlahAngkatan'));
    }

    
    public function dataMhsAktif($tahun)
    {
        $user = auth()->user();
        $nip = Departemen::where('email', $user->email)->value('NIP');

        $dept = Departemen::where('Departemen.email', $user->email)
        ->select('Departemen.*')
        ->first();

        $doswal = Dosen::join('Mahasiswa', 'Dosen.nama_doswal', '=', 'Mahasiswa.nama_doswal')
        ->where('Mahasiswa.angkatan', $tahun)
        ->first();

        $aktif = DB::table('Mahasiswa')
        ->where('Mahasiswa.angkatan', $tahun)
        ->where('Mahasiswa.status', 'AKTIF')
        ->select('Mahasiswa.*')
        ->get();
    
        return view('departemen.mhsaktif', compact('dept', 'aktif', 'tahun', 'doswal'));
    }

    public function dataMhsTdkAktif($tahun, $status)
    {
        $user = auth()->user();
        $nip = Departemen::where('email', $user->email)->value('NIP');

        $dept = Departemen::where('Departemen.email', $user->email)
        ->select('Departemen.*')
        ->first();

        $doswal = Dosen::join('Mahasiswa', 'Dosen.nama_doswal', '=', 'Mahasiswa.nama_doswal')
        ->where('Mahasiswa.angkatan', $tahun)
        ->first();

        $statusTidakAktif = ['TIDAK AKTIF', 'CUTI', 'MANGKIR', 'DO', 'UNDUR DIRI', 'LULUS', 'MENINGGAL DUNIA'];

        $tdkAktif = DB::table('Mahasiswa')
            ->where('Mahasiswa.angkatan', $tahun)
            ->where('Mahasiswa.status', $status) 
            ->select('Mahasiswa.*')
            ->get();
    
        return view('departemen.mhstdkaktif', compact('dept', 'tdkAktif', 'tahun', 'doswal', 'status'));
    }

    public function cetakStatus()
    {    
        $status = DB::table('Mahasiswa')
            ->select('Mahasiswa.*')
            ->get();
    
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('departemen.cetakrekapstatus', ['status' => $status]);
    
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
    
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('departemen.cetakMhsAktif', ['aktif' => $aktif, 'tahun' => $tahun, 'doswal' => $doswal]);
    
        return $pdf->stream('mahasiswa-aktif-' . $tahun . '.pdf');
    }
    
    public function cetakMhsTdkAktif($tahun, $status)
    {
        $doswal = Dosen::join('Mahasiswa', 'Dosen.nama_doswal', '=', 'Mahasiswa.nama_doswal')
            ->where('Mahasiswa.angkatan', $tahun)
            ->first();
    
        $tdkAktif = DB::table('Mahasiswa')
            ->where('Mahasiswa.angkatan', $tahun)
            ->where('Mahasiswa.status', $status) // Use the provided status parameter
            ->select('Mahasiswa.*')
            ->get();
    
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('departemen.cetakMhsTdkAktif', ['tdkAktif' => $tdkAktif, 'tahun' => $tahun, 'doswal' => $doswal, 'status' => $status]);
    
        return $pdf->stream('mahasiswa-tidak-aktif-' . $tahun . '-' . $status . '.pdf');
    }
    
}
