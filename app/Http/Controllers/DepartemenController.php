<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Support\Facades\DB;

class DepartemenController extends Controller
{
    public function index()
    {
        $nip = '198904012010052001';
        $dept = Departemen::where('Departemen.NIP', $nip)
        ->select('Departemen.*')
        ->first();

        $jumlahMahasiswa = DB::table('Mahasiswa')
        ->join('Departemen', 'Mahasiswa.fakultas', '=', 'Departemen.fakultas')
        ->leftJoin('PKL', 'Mahasiswa.id_mhs', '=', 'PKL.id_mhs')
        ->where('Departemen.NIP', $nip)
        ->count();

        $jumlahMahasiswaIRS = DB::table('Mahasiswa')
        ->join('Departemen', 'Mahasiswa.fakultas', '=', 'Departemen.fakultas')
        ->leftJoin('IRS', 'Mahasiswa.id_mhs', '=', 'IRS.id_mhs')
        ->where('IRS.status_irs', 'Terisi')
        ->count();

        $jumlahMahasiswaBlmIRS = DB::table('Mahasiswa')
        ->join('Departemen', 'Mahasiswa.fakultas', '=', 'Departemen.fakultas')
        ->leftJoin('IRS', 'Mahasiswa.id_mhs', '=', 'IRS.id_mhs')
        ->where('IRS.status_irs', 'Belum Terisi')
        ->count();

        $totalpersenIRS = ($jumlahMahasiswaIRS/$jumlahMahasiswa) * 100;
        $totalpersenBlmIRS = ($jumlahMahasiswaBlmIRS/$jumlahMahasiswa) * 100;

        $jumlahMahasiswaKHS = DB::table('Mahasiswa')
        ->join('Departemen', 'Mahasiswa.fakultas', '=', 'Departemen.fakultas')
        ->leftJoin('KHS', 'Mahasiswa.id_mhs', '=', 'KHS.id_mhs')
        ->where('KHS.status_khs', 'Terisi')
        ->count();

        $jumlahMahasiswaBlmKHS = DB::table('Mahasiswa')
        ->join('Departemen', 'Mahasiswa.fakultas', '=', 'Departemen.fakultas')
        ->leftJoin('KHS', 'Mahasiswa.id_mhs', '=', 'KHS.id_mhs')
        ->where('KHS.status_khs', 'Belum Terisi')
        ->count();

        $totalpersenKHS = ($jumlahMahasiswaKHS/$jumlahMahasiswa) * 100;
        $totalpersenBlmKHS = ($jumlahMahasiswaBlmKHS/$jumlahMahasiswa) * 100;

        $jumlahMahasiswaPKL = DB::table('Mahasiswa')
        ->join('Departemen', 'Mahasiswa.fakultas', '=', 'Departemen.fakultas')
        ->leftJoin('PKL', 'Mahasiswa.id_mhs', '=', 'PKL.id_mhs')
        ->where('PKL.status_pkl', 'Sudah PKL')
        ->count();

        $jumlahMahasiswaBlmPKL = DB::table('Mahasiswa')
        ->join('Departemen', 'Mahasiswa.fakultas', '=', 'Departemen.fakultas')
        ->leftJoin('PKL', 'Mahasiswa.id_mhs', '=', 'PKL.id_mhs')
        ->where('PKL.status_pkl', 'Belum PKL')
        ->count();

        $totalPersenPKL = ($jumlahMahasiswaPKL/$jumlahMahasiswa) * 100;
        $totalPersenBlmPKL = ($jumlahMahasiswaBlmPKL/$jumlahMahasiswa) * 100;

        $jumlahMahasiswaSkripsi = DB::table('Mahasiswa')
        ->join('Departemen', 'Mahasiswa.fakultas', '=', 'Departemen.fakultas')
        ->leftJoin('Skripsi', 'Mahasiswa.id_mhs', '=', 'Skripsi.id_mhs')
        ->where('Skripsi.status_skripsi', 'Sudah Skripsi')
        ->count();

        $jumlahMahasiswaBlmSkripsi = DB::table('Mahasiswa')
        ->join('Departemen', 'Mahasiswa.fakultas', '=', 'Departemen.fakultas')
        ->leftJoin('Skripsi', 'Mahasiswa.id_mhs', '=', 'Skripsi.id_mhs')
        ->where('Skripsi.status_skripsi', 'Belum Skripsi')
        ->count();

        $totalPersenSkripsi = ($jumlahMahasiswaSkripsi/$jumlahMahasiswa) * 100;
        $totalPersenBlmSkripsi = ($jumlahMahasiswaBlmSkripsi/$jumlahMahasiswa) * 100;

        $jumlahMahasiswaAktif = DB::table('Mahasiswa')
        ->join('Departemen', 'Mahasiswa.fakultas', '=', 'Departemen.fakultas')
        ->where('Mahasiswa.status', 'AKTIF')
        ->count();

        $jumlahMahasiswaTidakAktif = DB::table('Mahasiswa')
        ->join('Departemen', 'Mahasiswa.fakultas', '=', 'Departemen.fakultas')
        ->where('Mahasiswa.status', 'TIDAK AKTIF')
        ->count();

        return view('departemen.dashboard', compact('dept', 'jumlahMahasiswaPKL', 'totalPersenPKL', 'jumlahMahasiswa', 'jumlahMahasiswaBlmPKL', 'totalPersenBlmPKL',
    'jumlahMahasiswaIRS', 'jumlahMahasiswaBlmIRS', 'totalpersenIRS', 'totalpersenBlmIRS',
    'jumlahMahasiswaKHS', 'jumlahMahasiswaBlmKHS', 'totalpersenKHS', 'totalpersenBlmKHS',
    'jumlahMahasiswaSkripsi', 'jumlahMahasiswaBlmSkripsi', 'totalPersenSkripsi', 'totalPersenBlmSkripsi',
    'jumlahMahasiswaAktif','jumlahMahasiswaTidakAktif'));


    }
}
