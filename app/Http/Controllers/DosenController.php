<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DosenController extends Controller
{
    public function index()
    {

        /*$doswal = Mahasiswa::where('Mahasiswa.id_mhs', 1)
        ->leftJoin('IRS', 'Mahasiswa.id_mhs', '=', 'IRS.id_mhs')
        ->leftJoin('KHS', 'Mahasiswa.id_mhs', '=', 'KHS.id_mhs')
        ->leftJoin('PKL', 'Mahasiswa.id_mhs', '=', 'PKL.id_mhs')
        ->leftJoin('Skripsi', 'Mahasiswa.id_mhs', '=', 'Skripsi.id_mhs')
        ->leftjoin('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
        ->select('Mahasiswa.*', 'Dosen.NIP AS nip', 'IRS.jumlah_sks AS sks', 'IRS.smst_aktif AS semaktif',
        'KHS.SKS_kumulatif AS skskum', 'KHS.SKS_semester AS skssem', 'KHS.IP_smt AS ipsem', 'KHS.IP_kumulatif AS ipk',
        'PKL.status_pkl AS statuspkl', 'PKL.nilai_pkl AS nilaipkl',
        'Skripsi.status_skripsi AS statusskripsi', 'Skripsi.nilai_skripsi AS nilaiskripsi', 'Skripsi.lama_studi AS lamastudi', 'Skripsi.tanggal_sidang AS tglsidang',
        'Dosen.email AS emaildoswal', 'Dosen.nama_doswal AS namadoswal'
        )
        ->first();*/
        $nip = '197404011999031002';
        $doswal = Dosen::where('Dosen.NIP', $nip)
        ->select('Dosen.*')
        ->first();

        $jumlahMahasiswa = DB::table('Mahasiswa')
        ->join('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
        ->leftJoin('PKL', 'Mahasiswa.id_mhs', '=', 'PKL.id_mhs')
        ->where('Dosen.NIP', $nip)
        ->count();

        $jumlahMahasiswaIRS = DB::table('Mahasiswa')
        ->join('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
        ->leftJoin('IRS', 'Mahasiswa.id_mhs', '=', 'IRS.id_mhs')
        ->where('Dosen.NIP', $nip)
        ->where('IRS.status_irs', 'Terisi')
        ->count();

        $jumlahMahasiswaBlmIRS = DB::table('Mahasiswa')
        ->join('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
        ->leftJoin('IRS', 'Mahasiswa.id_mhs', '=', 'IRS.id_mhs')
        ->where('Dosen.NIP', $nip)
        ->where('IRS.status_irs', 'Belum Terisi')
        ->count();

        $totalpersenIRS = ($jumlahMahasiswaIRS/$jumlahMahasiswa) * 100;
        $totalpersenBlmIRS = ($jumlahMahasiswaBlmIRS/$jumlahMahasiswa) * 100;

        $jumlahMahasiswaKHS = DB::table('Mahasiswa')
        ->join('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
        ->leftJoin('KHS', 'Mahasiswa.id_mhs', '=', 'KHS.id_mhs')
        ->where('Dosen.NIP', $nip)
        ->where('KHS.status_khs', 'Terisi')
        ->count();

        $jumlahMahasiswaBlmKHS = DB::table('Mahasiswa')
        ->join('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
        ->leftJoin('KHS', 'Mahasiswa.id_mhs', '=', 'KHS.id_mhs')
        ->where('Dosen.NIP', $nip)
        ->where('KHS.status_khs', 'Belum Terisi')
        ->count();

        $totalpersenKHS = ($jumlahMahasiswaKHS/$jumlahMahasiswa) * 100;
        $totalpersenBlmKHS = ($jumlahMahasiswaBlmKHS/$jumlahMahasiswa) * 100;

        $jumlahMahasiswaPKL = DB::table('Mahasiswa')
        ->join('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
        ->leftJoin('PKL', 'Mahasiswa.id_mhs', '=', 'PKL.id_mhs')
        ->where('Dosen.NIP', $nip)
        ->where('PKL.status_pkl', 'Sudah PKL')
        ->count();

        $jumlahMahasiswaBlmPKL = DB::table('Mahasiswa')
        ->join('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
        ->leftJoin('PKL', 'Mahasiswa.id_mhs', '=', 'PKL.id_mhs')
        ->where('Dosen.NIP', $nip)
        ->where('PKL.status_pkl', 'Belum PKL')
        ->count();

        $totalPersenPKL = ($jumlahMahasiswaPKL/$jumlahMahasiswa) * 100;
        $totalPersenBlmPKL = ($jumlahMahasiswaBlmPKL/$jumlahMahasiswa) * 100;

        $jumlahMahasiswaSkripsi = DB::table('Mahasiswa')
        ->join('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
        ->leftJoin('Skripsi', 'Mahasiswa.id_mhs', '=', 'Skripsi.id_mhs')
        ->where('Dosen.NIP', $nip)
        ->where('Skripsi.status_skripsi', 'Sudah Skripsi')
        ->count();

        $jumlahMahasiswaBlmSkripsi = DB::table('Mahasiswa')
        ->join('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
        ->leftJoin('Skripsi', 'Mahasiswa.id_mhs', '=', 'Skripsi.id_mhs')
        ->where('Dosen.NIP', $nip)
        ->where('Skripsi.status_skripsi', 'Belum Skripsi')
        ->count();

        $totalPersenSkripsi = ($jumlahMahasiswaSkripsi/$jumlahMahasiswa) * 100;
        $totalPersenBlmSkripsi = ($jumlahMahasiswaBlmSkripsi/$jumlahMahasiswa) * 100;

        $jumlahMahasiswaAktif = DB::table('Mahasiswa')
        ->join('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
        ->where('Dosen.NIP', $nip)
        ->where('Mahasiswa.status', 'AKTIF')
        ->count();

        $jumlahMahasiswaTidakAktif = DB::table('Mahasiswa')
        ->join('Dosen', 'Mahasiswa.nama_doswal', '=', 'Dosen.nama_doswal')
        ->where('Dosen.NIP', $nip)
        ->where('Mahasiswa.status', 'TIDAK AKTIF')
        ->count();

        return view('dosen.dashboard', compact('doswal', 'jumlahMahasiswaPKL', 'totalPersenPKL', 'jumlahMahasiswa', 'jumlahMahasiswaBlmPKL', 'totalPersenBlmPKL',
    'jumlahMahasiswaIRS', 'jumlahMahasiswaBlmIRS', 'totalpersenIRS', 'totalpersenBlmIRS',
    'jumlahMahasiswaKHS', 'jumlahMahasiswaBlmKHS', 'totalpersenKHS', 'totalpersenBlmKHS',
    'jumlahMahasiswaSkripsi', 'jumlahMahasiswaBlmSkripsi', 'totalPersenSkripsi', 'totalPersenBlmSkripsi',
    'jumlahMahasiswaAktif','jumlahMahasiswaTidakAktif'));


    }
}
