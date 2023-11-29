<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\IRS;
use App\Models\KHS;
use App\Models\Mahasiswa;
use App\Models\PKL;
use App\Models\Skripsi;
use App\Notifications\IRSNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use PDF;

class DosenController extends Controller
{
    public function index()
    {

        $user = auth()->user();
        $nip = Dosen::where('email', $user->email)->value('NIP');

        $doswal = Dosen::where('Dosen.email', $user->email)
        ->select('Dosen.*')
        ->first();

        $jumlahMahasiswa = DB::table('Mahasiswa')
        ->leftJoin('Dosen', 'mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
        ->leftJoin('IRS', 'mahasiswa.id_mhs', '=', 'IRS.id_mhs')
        ->where('Dosen.NIP', $nip)
        ->whereBetween('irs.smst_aktif', [1, 14])
        
        ->count();

        // Jumlah Mahasiswa dengan IRS Terisi
        $jumlahMahasiswaIRS = DB::table('Mahasiswa')
        ->leftJoin('Dosen', 'mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
        ->leftJoin('IRS', 'mahasiswa.id_mhs', '=', 'IRS.id_mhs')
        ->where('Dosen.NIP', $nip)
        ->where('IRS.status_irs', 'Terisi')
        ->whereBetween('irs.smst_aktif', [1, 14])
        ->whereIn('IRS.id_irs', function ($query) {
            $query->select(DB::raw('MAX(id_irs) as id_irs'))
                ->from('IRS')
                ->groupBy('id_mhs');
        })
        ->count();

        // Jumlah Mahasiswa dengan IRS Belum Terisi
        $jumlahMahasiswaBlmIRS = DB::table('Mahasiswa')
        ->leftJoin('Dosen', 'mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
        ->leftJoin('IRS', 'mahasiswa.id_mhs', '=', 'IRS.id_mhs')
        ->where('Dosen.NIP', $nip)
        ->where('IRS.status_irs', 'Belum Terisi')
        ->whereBetween('irs.smst_aktif', [1, 14])
        ->whereIn('IRS.id_irs', function ($query) {
            $query->select(DB::raw('MAX(id_irs) as id_irs'))
                ->from('IRS')
                ->groupBy('id_mhs');
        })
        ->count();

        if ($jumlahMahasiswa > 0) {
            $totalpersenIRS = ($jumlahMahasiswaIRS / $jumlahMahasiswa) * 100;
            $totalpersenBlmIRS = ($jumlahMahasiswaBlmIRS / $jumlahMahasiswa) * 100;
        } else {
            $totalpersenIRS = 0;
            $totalpersenBlmIRS = 0;
        }

        // Jumlah Mahasiswa dengan KHS Terisi
        $jumlahMahasiswaKHS = DB::table('Mahasiswa')
            ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
            ->leftJoin('IRS', 'Mahasiswa.id_mhs', '=', 'IRS.id_mhs')
            ->leftJoin('KHS', 'Mahasiswa.id_mhs', '=', 'KHS.id_mhs')
            ->where('Dosen.NIP', $nip)
            ->where('KHS.status_khs', 'Terisi')
            ->whereBetween('KHS.smt_aktif', [1, 14])
            ->whereIn('IRS.id_irs', function ($query) {
                $query->select(DB::raw('MAX(id_irs) as id_irs'))
                    ->from('IRS')
                    ->groupBy('id_mhs');
            })
            ->count();

        // Jumlah Mahasiswa dengan KHS Belum Terisi
        $jumlahMahasiswaBlmKHS = DB::table('Mahasiswa')
            ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
            ->leftJoin('IRS', 'Mahasiswa.id_mhs', '=', 'IRS.id_mhs')
            ->leftJoin('KHS', 'Mahasiswa.id_mhs', '=', 'KHS.id_mhs')
            ->where('Dosen.NIP', $nip)
            ->where('KHS.status_khs', 'Belum Terisi')
            ->whereBetween('KHS.smt_aktif', [1, 14])
            ->whereIn('IRS.id_irs', function ($query) {
                $query->select(DB::raw('MAX(id_irs) as id_irs'))
                    ->from('IRS')
                    ->groupBy('id_mhs');
            })
            ->count();

        if ($jumlahMahasiswa > 0) {
            $totalpersenKHS = ($jumlahMahasiswaKHS / $jumlahMahasiswa) * 100;
            $totalpersenBlmKHS = ($jumlahMahasiswaBlmKHS / $jumlahMahasiswa) * 100;
        } else {
            $totalpersenKHS = 0;
            $totalpersenBlmKHS = 0;
        }

        $jumlahMahasiswaPKL = DB::table('Mahasiswa')
        ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
        ->leftJoin('IRS', 'Mahasiswa.id_mhs', '=', 'IRS.id_irs')
        ->leftJoin('PKL', 'Mahasiswa.id_mhs', '=', 'PKL.id_mhs')
        ->where('Dosen.NIP', $nip)
        ->where('PKL.status_pkl', 'Sudah PKL')
        ->whereBetween('IRS.smst_aktif', [1, 14])
        ->count();

        $jumlahMahasiswaBlmPKL = DB::table('Mahasiswa')
        ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
        ->leftJoin('IRS', 'Mahasiswa.id_mhs', '=', 'IRS.id_irs')
        ->leftJoin('PKL', 'Mahasiswa.id_mhs', '=', 'PKL.id_mhs')
        ->where('Dosen.NIP', $nip)
        ->where('PKL.status_pkl', 'Belum PKL')
        //->whereBetween('IRS.smst_aktif', [1, 14])
        ->count();

        if ($jumlahMahasiswa > 0) {
            $totalPersenPKL = ($jumlahMahasiswaPKL / $jumlahMahasiswa) * 100;
            $totalPersenBlmPKL = ($jumlahMahasiswaBlmPKL / $jumlahMahasiswa) * 100;
        } else {
            $totalPersenPKL = 0;
            $totalPersenBlmPKL = 0;
        }

        $jumlahMahasiswaSkripsi = DB::table('Mahasiswa')
        ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
        ->leftJoin('IRS', 'Mahasiswa.id_mhs', '=', 'IRS.id_irs')
        ->leftJoin('Skripsi', 'Mahasiswa.id_mhs', '=', 'Skripsi.id_mhs')
        ->where('Dosen.NIP', $nip)
        ->where('Skripsi.status_skripsi', 'Sudah Skripsi')
        ->whereBetween('IRS.smst_aktif', [1, 14])
        ->whereIn('IRS.id_irs', function ($query) {
            $query->select(DB::raw('MAX(id_irs) as id_irs'))
                ->from('IRS')
                ->groupBy('id_mhs');
        })
        ->count();

        $jumlahMahasiswaBlmSkripsi =DB::table('Mahasiswa')
        ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
        ->leftJoin('IRS', 'Mahasiswa.id_mhs', '=', 'IRS.id_irs')
        ->leftJoin('Skripsi', 'Mahasiswa.id_mhs', '=', 'Skripsi.id_mhs')
        ->where('Dosen.NIP', $nip)
        ->where('Skripsi.status_skripsi', 'Belum Skripsi')
        //->whereBetween('IRS.smst_aktif', [1, 14])
        ->count();

        if ($jumlahMahasiswa > 0) {
            $totalPersenSkripsi = ($jumlahMahasiswaSkripsi / $jumlahMahasiswa) * 100;
            $totalPersenBlmSkripsi = ($jumlahMahasiswaBlmSkripsi / $jumlahMahasiswa) * 100;
        } else {
            $totalPersenSkripsi = 0;
            $totalPersenBlmSkripsi = 0;
        }

        // Jumlah Mahasiswa Aktif
        $jumlahMahasiswaAktif = DB::table('Mahasiswa')
        ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
        ->leftJoin('IRS', 'Mahasiswa.id_mhs', '=', 'IRS.id_mhs')
        ->where('Dosen.NIP', $nip)
        ->where('Mahasiswa.status', 'AKTIF')
        ->whereIn('IRS.id_irs', function ($query) {
            $query->select(DB::raw('MAX(id_irs) as id_irs'))
                ->from('IRS')
                ->groupBy('id_mhs');
        })
        ->count();
    
    

        // Status Tidak Aktif
        $statusTidakAktif = ['TIDAK AKTIF', 'CUTI', 'MANGKIR', 'DO', 'UNDUR DIRI', 'LULUS', 'MENINGGAL DUNIA'];

        // Jumlah Mahasiswa Tidak Aktif
        $jumlahMahasiswaTidakAktif = DB::table('Mahasiswa')
            ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
            ->leftJoin('IRS', 'Mahasiswa.id_mhs', '=', 'IRS.id_mhs')
            ->where('Dosen.NIP', $nip)
            ->whereIn('Mahasiswa.status', $statusTidakAktif)
            ->whereBetween('IRS.smst_aktif', [1, 14])
            ->whereIn('IRS.id_irs', function ($query) {
                $query->select(DB::raw('MAX(id_irs) as id_irs'))
                    ->from('IRS')
                    ->groupBy('id_mhs');
            })
            ->count();

        $jmlSemStatus = [];

        for ($semester = 1; $semester <= 14; $semester++) {
            $statusTidakAktif = ['TIDAK AKTIF', 'CUTI', 'MANGKIR', 'DO', 'UNDUR DIRI', 'LULUS', 'MENINGGAL DUNIA'];

            $mahasiswaAktif = DB::table('Mahasiswa')
                ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
                ->leftJoin('IRS', 'Mahasiswa.id_mhs', '=', 'IRS.id_mhs')
                ->where('Dosen.NIP', $nip)
                ->where('Mahasiswa.status', 'AKTIF')
                ->where('IRS.smst_aktif', $semester)
                ->get();

            $mahasiswaTdkAktif = DB::table('Mahasiswa')
                ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
                ->leftJoin('IRS', 'Mahasiswa.id_mhs', '=', 'IRS.id_mhs')
                ->where('Dosen.NIP', $nip)
                ->where('IRS.smst_aktif', $semester)
                ->where('Mahasiswa.status', $statusTidakAktif)
                ->get();

            // Debug statements to inspect the data

            $jmlSemStatus[$semester]['mahasiswaAktif'] = count($mahasiswaAktif);
            $jmlSemStatus[$semester]['mahasiswaTdkAktif'] = count($mahasiswaTdkAktif);
        }

        $jmlSemIRS = [];

        for ($semester = 1; $semester <= 14; $semester++) {
            $mahasiswaIrs = DB::table('Mahasiswa')
                ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
                ->leftJoin('IRS', 'Mahasiswa.id_mhs', '=', 'IRS.id_mhs')
                ->where('Dosen.NIP', $nip)
                ->where('IRS.status_irs', 'Sudah Terisi')
                ->where('IRS.smst_aktif', $semester)
                ->get();

            $mahasiswaBelumIrs = DB::table('Mahasiswa')
                ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
                ->leftJoin('IRS', 'Mahasiswa.id_mhs', '=', 'IRS.id_mhs')
                ->where('Dosen.NIP', $nip)
                ->where('IRS.smst_aktif', $semester)
                ->where('IRS.status_irs', 'Belum Terisi')
                ->get();

            $jmlSemIRS[$semester]['mahasiswaIrs'] = count($mahasiswaIrs);
            $jmlSemIRS[$semester]['mahasiswaBelumIrs'] = count($mahasiswaBelumIrs);
        }

        $jmlSemKHS = [];

        for ($semester = 1; $semester <= 14; $semester++) {
            $mahasiswaKHS = DB::table('Mahasiswa')
                ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
                ->leftJoin('IRS', 'Mahasiswa.id_mhs', '=', 'IRS.id_mhs')
                ->leftJoin('KHS', 'Mahasiswa.id_mhs', '=', 'KHS.id_mhs')
                ->where('Dosen.NIP', $nip)
                ->where('IRS.smst_aktif', $semester)
                ->where('KHS.status_khs', 'Sudah Terisi')
                ->get();

            $mahasiswaBelumKHS = DB::table('Mahasiswa')
                ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
                ->leftJoin('IRS', 'Mahasiswa.id_mhs', '=', 'IRS.id_mhs')
                ->leftJoin('KHS', 'Mahasiswa.id_mhs', '=', 'KHS.id_mhs')
                ->where('Dosen.NIP', $nip)
                ->where('IRS.smst_aktif', $semester)
                ->where('KHS.status_khs', 'Belum Terisi')
                ->get();

            $jmlSemKHS[$semester]['mahasiswaKHS'] = count($mahasiswaKHS);
            $jmlSemKHS[$semester]['mahasiswaBelumKHS'] = count($mahasiswaBelumKHS);
        }

        $jmlSemPKL = [];

        for ($semester = 1; $semester <= 14; $semester++) {
            $mahasiswaPKL = DB::table('Mahasiswa')
                ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
                ->leftJoin('IRS', 'Mahasiswa.id_mhs', '=', 'IRS.id_mhs')
                ->leftJoin('PKL', 'Mahasiswa.id_mhs', '=', 'PKL.id_mhs')
                ->where('Dosen.NIP', $nip)
                ->where('IRS.smst_aktif', $semester)
                ->where('PKL.status_pkl', 'Sudah PKL')
                ->get();

            $mahasiswaBelumPKL = DB::table('Mahasiswa')
                ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
                ->leftJoin('IRS', 'Mahasiswa.id_mhs', '=', 'IRS.id_mhs')
                ->leftJoin('PKL', 'Mahasiswa.id_mhs', '=', 'PKL.id_mhs')
                ->where('Dosen.NIP', $nip)
                ->where('IRS.smst_aktif', $semester)
                ->where('PKL.status_pkl', 'Belum PKL')
                ->get();

            $jmlSemPKL[$semester]['mahasiswaPKL'] = count($mahasiswaPKL);
            $jmlSemPKL[$semester]['mahasiswaBelumPKL'] = count($mahasiswaBelumPKL);
        }

        $jmlSemSkripsi = [];

        for ($semester = 1; $semester <= 14; $semester++) {
            $mahasiswaSkripsi = DB::table('Mahasiswa')
                ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
                ->leftJoin('IRS', 'Mahasiswa.id_mhs', '=', 'IRS.id_mhs')
                ->leftJoin('Skripsi', 'Mahasiswa.id_mhs', '=', 'Skripsi.id_mhs')
                ->where('Dosen.NIP', $nip)
                ->where('IRS.smst_aktif', $semester)
                ->where('Skripsi.status_skripsi', 'Sudah Skripsi')
                ->get();

            $mahasiswaBelumSkripsi = DB::table('Mahasiswa')
                ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
                ->leftJoin('IRS', 'Mahasiswa.id_mhs', '=', 'IRS.id_mhs')
                ->leftJoin('Skripsi', 'Mahasiswa.id_mhs', '=', 'Skripsi.id_mhs')
                ->where('Dosen.NIP', $nip)
                ->where('IRS.smst_aktif', $semester)
                ->where('Skripsi.status_skripsi', 'Sudah Skripsi')
                ->get();

            $jmlSemSkripsi[$semester]['mahasiswaSkripsi'] = count($mahasiswaSkripsi);
            $jmlSemSkripsi[$semester]['mahasiswaBelumSkripsi'] = count($mahasiswaBelumSkripsi);

            $statusTidakAktif = ['AKTIF', 'TIDAK AKTIF', 'CUTI', 'MANGKIR', 'DO', 'UNDUR DIRI', 'LULUS', 'MENINGGAL DUNIA'];

            $cekStatusMahasiswa = DB::table('Mahasiswa')
            ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
            ->where('Dosen.NIP', $nip)
            ->whereIn('Mahasiswa.status', $statusTidakAktif) 
            ->get();
        
            $jumlahStatus = [];
            foreach ($statusTidakAktif as $status) {
                $count = $cekStatusMahasiswa->where('status', $status)->count();
                $jumlahStatus[$status] = $count;
            }
        }


        return view('dosen.dashboard', compact('doswal', 'jumlahMahasiswaPKL', 'totalPersenPKL', 'jumlahMahasiswa', 'jumlahMahasiswaBlmPKL', 'totalPersenBlmPKL',
    'jumlahMahasiswaIRS', 'jumlahMahasiswaBlmIRS', 'totalpersenIRS', 'totalpersenBlmIRS',
    'jumlahMahasiswaKHS', 'jumlahMahasiswaBlmKHS', 'totalpersenKHS', 'totalpersenBlmKHS',
    'jumlahMahasiswaSkripsi', 'jumlahMahasiswaBlmSkripsi', 'totalPersenSkripsi', 'totalPersenBlmSkripsi',
    'jumlahMahasiswaAktif','jumlahMahasiswaTidakAktif',
    'jmlSemIRS', 'jmlSemStatus', 'jmlSemPKL', 'jmlSemKHS', 'jmlSemSkripsi', 'jumlahStatus'));

    }


    public function show() {
        $user = auth()->user();
        $nip = Dosen::where('email', $user->email)->value('NIP');
        $doswal = Dosen::where('Dosen.email', $user->email)
            ->select('Dosen.*')
            ->first();

        // Subquery to get the maximum id_irs for each id_mhs
        $irsSubquery = DB::table('IRS')
            ->select('id_mhs', DB::raw('MAX(id_irs) as max_id_irs'))
            ->groupBy('id_mhs');

        // Subquery to get the maximum id_khs for each id_mhs
        $khsSubquery = DB::table('KHS')
            ->select('id_mhs', DB::raw('MAX(id_khs) as max_id_khs'))
            ->groupBy('id_mhs');

        // Subquery to get the maximum id_pkl for each id_mhs
        $pklSubquery = DB::table('PKL')
            ->select('id_mhs', DB::raw('MAX(id_pkl) as max_id_pkl'))
            ->groupBy('id_mhs');

        // Subquery to get the maximum id_skripsi for each id_mhs
        $skripsiSubquery = DB::table('Skripsi')
            ->select('id_mhs', DB::raw('MAX(id_skripsi) as max_id_skripsi'))
            ->groupBy('id_mhs');

        $mahasiswa = DB::table('Mahasiswa')
            ->join('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
            ->leftJoinSub($irsSubquery, 'irs_subquery', function ($join) {
                $join->on('Mahasiswa.id_mhs', '=', 'irs_subquery.id_mhs');
            })
            ->leftJoinSub($khsSubquery, 'khs_subquery', function ($join) {
                $join->on('Mahasiswa.id_mhs', '=', 'khs_subquery.id_mhs');
            })
            ->leftJoinSub($pklSubquery, 'pkl_subquery', function ($join) {
                $join->on('Mahasiswa.id_mhs', '=', 'pkl_subquery.id_mhs');
            })
            ->leftJoinSub($skripsiSubquery, 'skripsi_subquery', function ($join) {
                $join->on('Mahasiswa.id_mhs', '=', 'skripsi_subquery.id_mhs');
            })
            ->leftJoin('IRS', function ($join) {
                $join->on('Mahasiswa.id_mhs', '=', 'IRS.id_mhs')
                    ->on('IRS.id_irs', '=', 'irs_subquery.max_id_irs');
            })
            ->leftJoin('KHS', function ($join) {
                $join->on('Mahasiswa.id_mhs', '=', 'KHS.id_mhs')
                    ->on('KHS.id_khs', '=', 'khs_subquery.max_id_khs');
            })
            ->leftJoin('PKL', function ($join) {
                $join->on('Mahasiswa.id_mhs', '=', 'PKL.id_mhs')
                    ->on('PKL.id_pkl', '=', 'pkl_subquery.max_id_pkl');
            })
            ->leftJoin('Skripsi', function ($join) {
                $join->on('Mahasiswa.id_mhs', '=', 'Skripsi.id_mhs')
                    ->on('Skripsi.id_skripsi', '=', 'skripsi_subquery.max_id_skripsi');
            })
            ->select('Mahasiswa.*', 'IRS.berkas_irs AS irs', 'KHS.berkas_khs AS khs', 'PKL.berkas_pkl AS pkl', 'Skripsi.berkas_skripsi AS skripsi')
            ->where('Dosen.NIP', $nip)
            ->orderBy('Mahasiswa.nama', 'asc')
            ->paginate(10);

        return view('dosen.list', compact('doswal', 'mahasiswa'));
    }

    public function showIRS() {
        $user = auth()->user();
        $nip = Dosen::where('email', $user->email)->value('NIP');
        $doswal = Dosen::where('Dosen.email', $user->email)
            ->select('Dosen.*')
            ->first();
        
        $irsSubquery = DB::table('IRS')
        ->select('id_mhs', DB::raw('MAX(berkas_irs) as max_berkas_irs'))
        ->groupBy('id_mhs');
        
        $mahasiswa = DB::table('Mahasiswa')
        ->join('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
        ->leftJoinSub($irsSubquery, 'irs_subquery', function ($join) {
            $join->on('Mahasiswa.id_mhs', '=', 'irs_subquery.id_mhs');
        })
        ->leftJoin('IRS', 'Mahasiswa.id_mhs', '=', 'IRS.id_mhs')
        ->select('Mahasiswa.*', 'irs_subquery.max_berkas_irs AS irs', 'IRS.persetujuan AS persetujuan_irs')
        ->where('Dosen.NIP', $nip)
        ->where(function ($query) {
            $query->where('IRS.persetujuan', '!=', 'Disetujui');})   
        ->orderBy('Mahasiswa.nama', 'asc')
        ->paginate(10);
    
        return view('dosen.irs', compact('doswal', 'mahasiswa'));
    }
    
    public function showKHS() {
        $user = auth()->user();
        $nip = Dosen::where('email', $user->email)->value('NIP');
        $doswal = Dosen::where('Dosen.email', $user->email)
            ->select('Dosen.*')
            ->first();
        
        $khsSubquery = DB::table('KHS')
        ->select('id_mhs', DB::raw('MAX(berkas_khs) as max_berkas_khs'))
        ->groupBy('id_mhs');
        
        $mahasiswa = DB::table('Mahasiswa')
        ->join('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
        ->leftJoinSub($khsSubquery, 'khs_subquery', function ($join) {
            $join->on('Mahasiswa.id_mhs', '=', 'khs_subquery.id_mhs');
        })
        ->leftJoin('KHS', 'Mahasiswa.id_mhs', '=', 'KHS.id_mhs')
        ->select('Mahasiswa.*', 'khs_subquery.max_berkas_khs AS khs', 'KHS.persetujuan AS persetujuan_khs')
        ->where('Dosen.NIP', $nip)
        ->where(function ($query) {
            $query->where('KHS.persetujuan', '!=', 'Disetujui');})        
        ->orderBy('Mahasiswa.nama', 'asc')
        ->paginate(10);
    
        return view('dosen.khs', compact('doswal', 'mahasiswa'));
    }
    
    public function showPKL() {
        $user = auth()->user();
        $nip = Dosen::where('email', $user->email)->value('NIP');
        $doswal = Dosen::where('Dosen.email', $user->email)
            ->select('Dosen.*')
            ->first();
        
        $pklSubquery = DB::table('pkl')
        ->select('id_mhs', DB::raw('MAX(berkas_pkl) as max_berkas_pkl'))
        ->groupBy('id_mhs');
        
        $mahasiswa = DB::table('Mahasiswa')
        ->join('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
        ->leftJoinSub($pklSubquery, 'pkl_subquery', function ($join) {
            $join->on('Mahasiswa.id_mhs', '=', 'pkl_subquery.id_mhs');
        })
        ->leftJoin('PKL', 'Mahasiswa.id_mhs', '=', 'PKL.id_mhs')
        ->select('Mahasiswa.*', 'pkl_subquery.max_berkas_pkl AS pkl', 'PKL.persetujuan AS persetujuan_pkl')
        ->where('Dosen.NIP', $nip)
        ->where(function ($query) {
            $query->where('PKL.persetujuan', '!=', 'Disetujui');})
        ->orderBy('Mahasiswa.nama', 'asc')
        ->paginate(10);
    
        return view('dosen.pkl', compact('doswal', 'mahasiswa'));
    }

    public function showSkripsi() {
        $user = auth()->user();
        $nip = Dosen::where('email', $user->email)->value('NIP');
        $doswal = Dosen::where('Dosen.email', $user->email)
            ->select('Dosen.*')
            ->first();
        
        $skripsiSubquery = DB::table('skripsi')
        ->select('id_mhs', DB::raw('MAX(berkas_skripsi) as max_berkas_skripsi'))
        ->groupBy('id_mhs');
        
        $mahasiswa = DB::table('Mahasiswa')
        ->join('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
        ->leftJoinSub($skripsiSubquery, 'skripsi_subquery', function ($join) {
            $join->on('Mahasiswa.id_mhs', '=', 'skripsi_subquery.id_mhs');
        })
        ->leftJoin('skripsi', 'Mahasiswa.id_mhs', '=', 'skripsi.id_mhs')
        ->select('Mahasiswa.*', 'skripsi_subquery.max_berkas_skripsi AS skripsi', 'skripsi.persetujuan AS persetujuan_skripsi')
        ->where('Dosen.NIP', $nip)
        ->where(function ($query) {
            $query->where('skripsi.persetujuan', '!=', 'Disetujui');})        
        ->orderBy('Mahasiswa.nama', 'asc')
        ->paginate(10);
    
        return view('dosen.skripsi', compact('doswal', 'mahasiswa'));
    }

    public function verifikasi($id_mhs) {
        // Cari mahasiswa berdasarkan ID
        $mahasiswa = Mahasiswa::find($id_mhs);

        if (!$mahasiswa) {
            // Handle jika mahasiswa tidak ditemukan
            return redirect()->back()->with('error', 'Mahasiswa tidak ditemukan.');
        }

        // Periksa apakah persetujuan sudah "Disetujui"
        if ($mahasiswa->persetujuan === 'Disetujui') {
            // Jika sudah disetujui, Anda bisa melakukan sesuatu di sini, misalnya memberikan pesan error atau tindakan lainnya
            $mahasiswa->persetujuan = 'Belum Disetujui';
            $mahasiswa->save();
            return redirect()->back()->with('error', 'Persetujuan sudah disetujui, Anda tidak dapat mengubahnya lagi.');
        }

        // Jika persetujuan belum "Disetujui", maka izinkan dosen untuk mengubahnya
        $mahasiswa->persetujuan = 'Disetujui';
        $mahasiswa->save();

        return redirect()->back()->with('success', 'Persetujuan mahasiswa berhasil diubah.');
    }

    public function verifikasiIRS(Request $request, $NIM) {
        $mahasiswa = Mahasiswa::where('NIM', $NIM)->first();
        
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Mahasiswa tidak ditemukan.');
        }
        
        $IRS = IRS::where('NIM', $mahasiswa->NIM)->latest('id_irs')->first(); // Mengambil data IRS terbaru berdasarkan id_irs
        
        if (!$IRS) {
            return redirect()->back()->with('error', 'IRS tidak ditemukan.');
        }
        
        // Mendapatkan nilai persetujuan dari formulir
        $persetujuan_irs = $request->input('persetujuan_irs');
        // dd($persetujuan_irs);
        if ($persetujuan_irs === 'tidak_setuju') {
            // Jika yang dipilih adalah "Tidak Setuju," maka hapus data IRS terbaru
            $IRS->delete();
            return redirect()->back()->with('error', 'IRS tidak disetujui dan telah dihapus.');
        } else {
            // Jika yang dipilih adalah "Setuju," maka setujui IRS
            $IRS->persetujuan = 'Disetujui';
            $IRS->save();
            return redirect()->back()->with('success', 'Verifikasi IRS berhasil dilakukan.');
        }
    }
      
    
    public function verifikasiKHS(Request $request, $NIM) {
        $mahasiswa = Mahasiswa::where('NIM', $NIM)->first();
        
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Mahasiswa tidak ditemukan.');
        }
        
        $KHS = KHS::where('NIM', $mahasiswa->NIM)->latest('id_khs')->first(); // Mengambil data IRS terbaru berdasarkan id_khs
        
        if (!$KHS) {
            return redirect()->back()->with('error', 'KHS tidak ditemukan.');
        }
        
        // Mendapatkan nilai persetujuan dari formulir
        $persetujuan_khs = $request->input('persetujuan_khs');
        // dd($persetujuan_khs);
        if ($persetujuan_khs === 'tidak_setuju') {
            // Jika yang dipilih adalah "Tidak Setuju," maka hapus data KHS terbaru
            $KHS->delete();
            return redirect()->back()->with('error', 'KHS tidak disetujui dan telah dihapus.');
        } else {
            // Jika yang dipilih adalah "Setuju," maka setujui KHS
            $KHS->persetujuan = 'Disetujui';
            $KHS->save();
            return redirect()->back()->with('success', 'Verifikasi KHS berhasil dilakukan.');
        }
    }

    public function verifikasiPKL(Request $request, $NIM) {
        $mahasiswa = Mahasiswa::where('NIM', $NIM)->first();
        
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Mahasiswa tidak ditemukan.');
        }
        
        $PKL = PKL::where('NIM', $mahasiswa->NIM)->latest('id_pkl')->first(); // Mengambil data IRS terbaru berdasarkan id_pkl
        
        if (!$PKL) {
            return redirect()->back()->with('error', 'PKL tidak ditemukan.');
        }
        
        // Mendapatkan nilai persetujuan dari formulir
        $persetujuan_pkl = $request->input('persetujuan_pkl');
        // dd($persetujuan_pkl);
        if ($persetujuan_pkl === 'tidak_setuju') {
            // Jika yang dipilih adalah "Tidak Setuju," maka hapus data PKL terbaru
            $PKL->delete();
            return redirect()->back()->with('error', 'PKL tidak disetujui dan telah dihapus.');
        } else {
            // Jika yang dipilih adalah "Setuju," maka setujui PKL
            $PKL->persetujuan = 'Disetujui';
            $PKL->save();
            return redirect()->back()->with('success', 'Verifikasi PKL berhasil dilakukan.');
        }
    }
    
    public function verifikasiSkripsi($NIM) {
        $mahasiswa = Mahasiswa::find($NIM);
    
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Mahasiswa tidak ditemukan.');
        }
    
        $Skripsi = Skripsi::where('NIM', $mahasiswa->NIM)->first();
    
        if (!$Skripsi) {
            return redirect()->back()->with('error', 'Skripsi tidak ditemukan.');
        }
    
        $Skripsi->persetujuan = 'Disetujui';
        $Skripsi->save();
    
        return redirect()->back()->with('success', 'Verifikasi Skripsi berhasil dilakukan.');
    } 

    public function daftarMahasiswa(Request $request)
    {
        $user = auth()->user();
        $nip = Dosen::where('email', $user->email)->value('NIP');
        $doswal = Dosen::where('Dosen.email', $user->email)
        ->select('Dosen.*')
        ->first();
    
        $query = DB::table('Mahasiswa')
            ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
            ->leftJoin('Kota_kab', 'Mahasiswa.kode_kota_kab', '=', 'Kota_kab.kode_kota_kab')
            ->select('Mahasiswa.*', 'Dosen.NIP AS nip', 'Kota_kab.nama_kota_kab AS nama_kota_kab')
            ->where('Dosen.NIP', $nip);
    
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($query) use ($searchTerm) {
                $query->where('Mahasiswa.nama', 'like', '%' . $searchTerm . '%')
                    ->orWhere('Mahasiswa.nim', 'like', '%' . $searchTerm . '%')
                    ->orWhere('Mahasiswa.angkatan', 'like', '%' . $searchTerm . '%')
                    ->orWhere('Mahasiswa.status', 'like', '%' . $searchTerm . '%')
                    ->orWhere('Mahasiswa.alamat', 'like', '%' . $searchTerm . '%')
                    ->orWhere('Mahasiswa.jalur_masuk', 'like', '%' . $searchTerm . '%')
                    ->orWhere('Kota_kab.nama_kota_kab', 'like', '%' . $searchTerm . '%');
            });
        }
    
        $mahasiswa = $query->get();
    
        return view('dosen.daftarmahasiswa', compact('mahasiswa', 'doswal'));
    }

    public function perwalian($NIM)
    {
        $user = auth()->user();
        $nip = Dosen::where('email', $user->email)->value('NIP');
        $doswal = Dosen::where('Dosen.email', $user->email)
        ->select('Dosen.*')
        ->first();


        $mahasiswa = Mahasiswa::where('nim', $NIM)->first();
        $allSemester = range(1, 14);
        $semester = request()->query('semester');

        $irs = $mahasiswa->irs()
            ->where('smst_aktif', $semester)
            ->first();
        
        $khs = $mahasiswa->khs()
            ->where('smt_aktif', $semester)
            ->first();

        $pkl = $mahasiswa->pkl()
            ->where('nim', $NIM)
            ->first();

        $skripsi = $mahasiswa->skripsi()
            ->where('nim', $NIM)
            ->first();
        
        return view('dosen.perwalian', compact('doswal', 'mahasiswa', 'semester', 'allSemester', 'irs', 'khs', 'pkl', 'skripsi'));
    }
    
    

    public function rekappkl()
    {
        $user = auth()->user();
        $nip = Dosen::where('email', $user->email)->value('NIP');

        $doswal = Dosen::where('Dosen.email', $user->email)
            ->select('Dosen.*')
            ->first();

        $tahun = DB::table('Mahasiswa')
            ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
            ->where('Dosen.NIP', $nip) 
            ->select('angkatan')
            ->distinct()
            ->pluck('angkatan')
            ->toArray();

        $jumlahAngkatan = count($tahun);

        $jumlahMahasiswaPKL = [];
        $jumlahMahasiswaBLMPKL = [];

        foreach ($tahun as $year) {
            $jumlahMahasiswaPKL[$year] = PKL::join('Mahasiswa', 'PKL.id_mhs', '=', 'Mahasiswa.id_mhs')
                ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
                ->where('Dosen.NIP', $nip) 
                ->where('Mahasiswa.angkatan', $year)
                ->where('PKL.status_pkl', 'Sudah PKL')
                ->where('PKL.persetujuan', 'Disetujui')
                ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
                ->count();

            $jumlahMahasiswaBlmPKL[$year] = DB::table('Mahasiswa')
                ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
                ->leftJoin('PKL', 'Mahasiswa.id_mhs', '=', 'PKL.id_mhs')
                ->where('Dosen.NIP', $nip) 
                ->where('PKL.status_pkl', 'Belum PKL')
                ->where('Mahasiswa.angkatan', $year)
                ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
                ->count();
        }

        return view('dosen.rekapPKL', compact('doswal', 'jumlahMahasiswaPKL', 'jumlahMahasiswaBlmPKL', 'tahun', 'jumlahAngkatan'));
    }

    public function dataSudahPKL($tahun)
    {
        $user = auth()->user();
        $nip = Dosen::where('email', $user->email)->value('NIP');

        $doswal = Dosen::where('Dosen.email', $user->email)
            ->select('Dosen.*')
            ->first();

        $pkl = PKL::join('Mahasiswa', 'PKL.id_mhs', '=', 'Mahasiswa.id_mhs')
        ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
        ->where('Dosen.NIP', $nip) 
        ->where('Mahasiswa.angkatan', $tahun)
        ->where('PKL.status_pkl', 'Sudah PKL')
        ->where('PKL.persetujuan', 'Disetujui')
        ->select('pkl.*', 'mahasiswa.NIM as NIM', 'mahasiswa.nama as nama', 'mahasiswa.angkatan as angkatan')
        ->get();
    
        return view('dosen.sudahpkl', compact('doswal', 'pkl', 'tahun'));
    }

    public function dataBlmPKL($tahun)
    {
        $user = auth()->user();
        $nip = Dosen::where('email', $user->email)->value('NIP');

        $doswal = Dosen::where('Dosen.email', $user->email)
            ->select('Dosen.*')
            ->first();

        $pkl = PKL::join('Mahasiswa', 'PKL.id_mhs', '=', 'Mahasiswa.id_mhs')
        ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
        ->where('Dosen.NIP', $nip) 
        ->where('Mahasiswa.angkatan', $tahun)
        ->where('PKL.status_pkl', 'Belum PKL')
        ->select('pkl.*', 'mahasiswa.NIM as NIM', 'mahasiswa.nama as nama', 'mahasiswa.angkatan as angkatan')
        ->get();
    
        return view('dosen.belumpkl', compact('doswal', 'pkl', 'tahun'));
    }

    public function cetakPKL()
    {    
        $user = auth()->user();
        $nip = Dosen::where('email', $user->email)->value('NIP');
    
        $doswal = Dosen::where('email', $user->email)
            ->select('Dosen.*')
            ->first();
    
        $pkl = PKL::join('Mahasiswa', 'PKL.id_mhs', '=', 'Mahasiswa.id_mhs')
            ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
            ->where('Dosen.NIP', $nip) 
            ->select('PKL.*', 'Mahasiswa.NIM as NIM', 'Mahasiswa.nama as nama', 'Mahasiswa.angkatan as angkatan', 'Dosen.NIP as nip', 'Dosen.nama_doswal as nama_doswal')
            ->get();
    
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dosen.cetakrekappkl', ['doswal' => $doswal, 'pkl' => $pkl]);
    
        return $pdf->stream('rekap-pkl.pdf');
    }
    

    public function cetakSudahPKL($tahun)
    {
        $user = auth()->user();
        $nip = Dosen::where('email', $user->email)->value('NIP');
    
        $doswal = Dosen::where('email', $user->email)
            ->select('Dosen.*')
            ->first();

        $pkl = PKL::join('Mahasiswa', 'PKL.id_mhs', '=', 'Mahasiswa.id_mhs')
            ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
            ->where('Dosen.NIP', $nip) 
            ->where('Mahasiswa.angkatan', $tahun)
            ->where('PKL.status_pkl', 'Sudah PKL')
            ->where('PKL.persetujuan', 'Disetujui')
            ->select('pkl.*', 'mahasiswa.NIM as NIM', 'mahasiswa.nama as nama', 'mahasiswa.angkatan as angkatan')
            ->get();
    
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dosen.cetaksudahpkl', ['pkl' => $pkl, 'tahun' => $tahun, 'doswal' => $doswal]);
    
        return $pdf->stream('sudah-pkl' . $tahun . '.pdf');
    }
    
    public function cetakBelumPKL($tahun)
    {
        $user = auth()->user();
        $nip = Dosen::where('email', $user->email)->value('NIP');
    
        $doswal = Dosen::where('email', $user->email)
            ->select('Dosen.*')
            ->first();

        $pkl = PKL::join('Mahasiswa', 'PKL.id_mhs', '=', 'Mahasiswa.id_mhs')
            ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
            ->where('Dosen.NIP', $nip) 
            ->where('Mahasiswa.angkatan', $tahun)
            ->where('PKL.status_pkl', 'Belum PKL')
            ->select('pkl.*', 'mahasiswa.NIM as NIM', 'mahasiswa.nama as nama', 'mahasiswa.angkatan as angkatan')
            ->get();
    
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dosen.cetakbelumpkl', ['pkl' => $pkl, 'tahun' => $tahun, 'doswal' => $doswal]);
    
        return $pdf->stream('belum-pkl' . $tahun . '.pdf');
    }

     // Skripsi
     public function rekapskripsi()
     {
     $user = auth()->user();
     $nip = Dosen::where('email', $user->email)->value('NIP');
 
     $doswal = Dosen::where('Dosen.email', $user->email)
     ->select('Dosen.*')
     ->first();
 
     $tahun = DB::table('Mahasiswa')
     ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
     ->where('Dosen.NIP', $nip) 
     ->select('angkatan')
     ->distinct()
     ->pluck('angkatan')
     ->toArray();

     $jumlahAngkatan = count($tahun);

     $jumlahMahasiswaSkripsi = [];
     $jumlahMahasiswaBlmSkripsi = [];
 
     foreach ($tahun as $year) {
         $jumlahMahasiswaSkripsi[$year] = Skripsi::join('Mahasiswa', 'Skripsi.id_mhs', '=', 'Mahasiswa.id_mhs')
         ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
         ->where('Dosen.NIP', $nip) 
         ->where('Mahasiswa.angkatan', $year)
         ->where('Skripsi.status_skripsi', 'Sudah Skripsi')
         ->where('Skripsi.persetujuan', 'Disetujui')
         ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
         ->count();
 
         $jumlahMahasiswaBlmSkripsi[$year] = DB::table('Mahasiswa')
         ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
         ->leftJoin('Skripsi', 'Mahasiswa.id_mhs', '=', 'Skripsi.id_mhs')
         ->where('Dosen.NIP', $nip) 
         ->where('Skripsi.status_skripsi', 'Belum Skripsi')
         ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
         ->where('Mahasiswa.angkatan', $year)
         ->count();
     }
 
     return view('dosen.rekapSkripsi', compact('doswal', 'jumlahMahasiswaSkripsi', 'jumlahMahasiswaBlmSkripsi', 'tahun', 'jumlahAngkatan'));
     }
         
     public function dataSudahSkripsi($tahun)
     {
         $user = auth()->user();
         $nip = Dosen::where('email', $user->email)->value('NIP');
 
         $doswal = Dosen::where('Dosen.email', $user->email)
         ->select('Dosen.*')
         ->first();
 
         $skripsi = Skripsi::join('Mahasiswa', 'Skripsi.id_mhs', '=', 'Mahasiswa.id_mhs')
         ->where('Mahasiswa.angkatan', $tahun)
         ->where('Skripsi.status_skripsi', 'Sudah Skripsi')
         ->where('Skripsi.persetujuan', 'Disetujui')
         ->select('Skripsi.*', 'mahasiswa.NIM as NIM', 'mahasiswa.nama as nama', 'mahasiswa.angkatan as angkatan')
         ->get();
     
         return view('dosen.sudahSkripsi', compact('doswal', 'skripsi', 'tahun', 'doswal'));
     }
 
     public function dataBlmSkripsi($tahun)
     {
         $user = auth()->user();
         $nip = Dosen::where('email', $user->email)->value('NIP');
 
         $doswal = Dosen::where('Dosen.email', $user->email)
         ->select('Dosen.*')
         ->first();
 
         $skripsi = Skripsi::join('Mahasiswa', 'Skripsi.id_mhs', '=', 'Mahasiswa.id_mhs')
         ->where('Mahasiswa.angkatan', $tahun)
         ->where('Skripsi.status_skripsi', 'Belum Skripsi')
         ->select('Skripsi.*', 'mahasiswa.NIM as NIM', 'mahasiswa.nama as nama', 'mahasiswa.angkatan as angkatan')
         ->get();
     
         return view('dosen.belumSkripsi', compact('doswal', 'skripsi', 'tahun', 'doswal'));
     }
 
     public function cetakSkripsi()
     {    
        $user = auth()->user();
        $nip = Dosen::where('email', $user->email)->value('NIP');
    
        $doswal = Dosen::where('email', $user->email)
            ->select('Dosen.*')
            ->first();

         $skripsi = Skripsi::join('Mahasiswa', 'Skripsi.id_mhs', '=', 'Mahasiswa.id_mhs')
            ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')   
            ->where('Dosen.NIP', $nip) 
            ->select('Skripsi.*', 'mahasiswa.NIM as NIM', 'mahasiswa.nama as nama', 'mahasiswa.angkatan as angkatan')
            ->get();
     
         $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dosen.cetakrekapskripsi', ['doswal' => $doswal,'skripsi' => $skripsi]);
     
         return $pdf->stream('rekap-skripsi.pdf');
     }
 
     public function cetakSudahSkripsi($tahun)
     {
        $user = auth()->user();
        $nip = Dosen::where('email', $user->email)->value('NIP');
    
        $doswal = Dosen::where('email', $user->email)
            ->select('Dosen.*')
            ->first();
 
         $skripsi = Skripsi::join('Mahasiswa', 'Skripsi.id_mhs', '=', 'Mahasiswa.id_mhs')
            ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
            ->where('Dosen.NIP', $nip )
            ->where('Mahasiswa.angkatan', $tahun)
            ->where('Skripsi.status_skripsi', 'Sudah Skripsi')
            ->where('Skripsi.persetujuan', 'Disetujui')
            ->select('Skripsi.*', 'mahasiswa.NIM as NIM', 'mahasiswa.nama as nama', 'mahasiswa.angkatan as angkatan')
            ->get();
     
         $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dosen.cetaksudahskripsi', ['skripsi' => $skripsi, 'tahun' => $tahun, 'doswal' => $doswal]);
     
         return $pdf->stream('sudah-skripsi' . $tahun . '.pdf');
     }
     
     public function cetakBelumSkripsi($tahun)
     {
        $user = auth()->user();
        $nip = Dosen::where('email', $user->email)->value('NIP');
    
        $doswal = Dosen::where('email', $user->email)
            ->select('Dosen.*')
            ->first();

 
         $skripsi = Skripsi::join('Mahasiswa', 'Skripsi.id_mhs', '=', 'Mahasiswa.id_mhs')
            ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
            ->where('Dosen.NIP', $nip) 
            ->where('Mahasiswa.angkatan', $tahun)
            ->where('Skripsi.status_skripsi', 'Belum Skripsi')
            ->select('Skripsi.*', 'mahasiswa.NIM as NIM', 'mahasiswa.nama as nama', 'mahasiswa.angkatan as angkatan')
            ->get();
     
         $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dosen.cetakbelumskripsi', ['skripsi' => $skripsi, 'tahun' => $tahun, 'doswal' => $doswal]);
     
         return $pdf->stream('belum-skripsi' . $tahun . '.pdf');
     }

     public function rekapStatus()
     {
         $user = auth()->user();
         $nip = Dosen::where('email', $user->email)->value('NIP');
     
         $doswal = Dosen::where('Dosen.email', $user->email)
             ->select('Dosen.*')
             ->first();
     
         $statusTidakAktif = ['TIDAK AKTIF', 'CUTI', 'MANGKIR', 'DO', 'UNDUR DIRI', 'LULUS', 'MENINGGAL DUNIA'];
     
         $tahun = DB::table('Mahasiswa')
         ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
         ->where('Dosen.NIP', $nip) 
         ->select('angkatan')
         ->distinct()
         ->pluck('angkatan')
         ->toArray();

         $jumlahAngkatan = count($tahun);

         $jumlahMahasiswaAktif = [];
         $jumlahMahasiswaTidakAktif = [];
     
         foreach ($tahun as $year) {
             $jumlahMahasiswaAktif[$year] = DB::table('Mahasiswa')
                ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
                ->where('Dosen.NIP', $nip) 
                ->where('Mahasiswa.angkatan', $year)
                ->where('Mahasiswa.status', 'AKTIF')
                ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
                ->count();
     
             $jumlahMahasiswaTidakAktif[$year] = DB::table('Mahasiswa')
                ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
                ->where('Dosen.NIP', $nip) 
                ->where('Mahasiswa.angkatan', $year)
                ->whereIn('Mahasiswa.status', $statusTidakAktif)
                ->select(DB::raw('COUNT(DISTINCT Mahasiswa.id_mhs) as jumlah'))
                ->count();
         }
     
         return view('dosen.rekapstatus', compact('doswal', 'jumlahMahasiswaAktif', 'jumlahMahasiswaTidakAktif', 'tahun', 'jumlahAngkatan'));
     }

     public function dataMhsAktif($tahun)
     {
         $user = auth()->user();
         $nip = Dosen::where('email', $user->email)->value('NIP');
 
         $doswal = Dosen::where('Dosen.email', $user->email)
         ->select('Dosen.*')
         ->first();
 
         $aktif = DB::table('Mahasiswa')
         ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
         ->where('Dosen.NIP', $nip) 
         ->where('Mahasiswa.angkatan', $tahun)
         ->where('Mahasiswa.status', 'AKTIF')
         ->select('Mahasiswa.*')
         ->get();
     
         return view('dosen.mhsaktif', compact('doswal', 'aktif', 'tahun', 'doswal'));
     }
 
     public function dataMhsTdkAktif($tahun)
     {
         $user = auth()->user();
         $nip = Dosen::where('email', $user->email)->value('NIP');
 
         $doswal = Dosen::where('Dosen.email', $user->email)
         ->select('Dosen.*')
         ->first();
 
         $statusTidakAktif = ['TIDAK AKTIF', 'CUTI', 'MANGKIR', 'DO', 'UNDUR DIRI', 'LULUS', 'MENINGGAL DUNIA'];
 
         $tdkAktif = DB::table('Mahasiswa')
         ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
         ->where('Dosen.NIP', $nip) 
         ->where('Mahasiswa.angkatan', $tahun)
         ->whereIn('Mahasiswa.status', $statusTidakAktif)
         ->select('Mahasiswa.*')
         ->get();
     
         return view('dosen.mhstdkaktif', compact('doswal', 'tdkAktif', 'tahun', 'doswal'));
     }

     public function cetakStatus()
     {    
        $user = auth()->user();
        $nip = Dosen::where('email', $user->email)->value('NIP');
    
        $doswal = Dosen::where('email', $user->email)
            ->select('Dosen.*')
            ->first();
            
        $status = DB::table('Mahasiswa')
            ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
            ->where('Dosen.NIP', $nip) 
            ->select('Mahasiswa.*')
            ->get();
     
         $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dosen.cetakrekapstatus', ['doswal' => $doswal, 'status' => $status]);
     
         return $pdf->stream('rekap-status.pdf');
     }
 
     public function cetakMhsAktif($tahun)
     {
        $user = auth()->user();
        $nip = Dosen::where('email', $user->email)->value('NIP');
    
        $doswal = Dosen::where('email', $user->email)
            ->select('Dosen.*')
            ->first();
 
        $aktif = DB::table('Mahasiswa')
            ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
            ->where('Mahasiswa.angkatan', $tahun)
            ->where('Dosen.NIP', $nip)
            ->where('Mahasiswa.status', 'AKTIF')
            ->select('Mahasiswa.*')
            ->get();
     
         $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dosen.cetakMhsAktif', ['aktif' => $aktif, 'tahun' => $tahun, 'doswal' => $doswal]);
     
         return $pdf->stream('mahasiswa-aktif-' . $tahun . '.pdf');
     }
     
     public function cetakMhsTdkAktif($tahun)
     {
        $user = auth()->user();
        $nip = Dosen::where('email', $user->email)->value('NIP');
    
        $doswal = Dosen::where('email', $user->email)
            ->select('Dosen.*')
            ->first();
 
         $statusTidakAktif = ['TIDAK AKTIF', 'CUTI', 'MANGKIR', 'DO', 'UNDUR DIRI', 'LULUS', 'MENINGGAL DUNIA'];
 
         $tdkAktif = DB::table('Mahasiswa')
            ->leftJoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
            ->where('Mahasiswa.angkatan', $tahun)
            ->where('Dosen.NIP', $nip)
            ->whereIn('Mahasiswa.status', $statusTidakAktif)
            ->select('Mahasiswa.*')
            ->get();
     
         $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dosen.cetakMhsTdkAktif', ['tdkAktif' => $tdkAktif, 'tahun' => $tahun, 'doswal' => $doswal]);
     
         return $pdf->stream('mahasiswa-tidak-aktif-' . $tahun . '.pdf');
     }
 
     
}
