<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';

    protected $primaryKey = 'id_mhs';

    public $timestamps = false;

    protected $fillable = [
        'id_mhs',
        'NIM',
        'fakultas',
        'nama',
        'email',
        'alamat',
        'no_HP',
        'angkatan',
        'status',
        'jalur_masuk',
        'foto',
        'kode_kota_kab',
        'nama_doswal',
        'persetujuan'];

    public static function rules()
    {
        return [
            'NIM' => 'required|string|max:14',
            'fakultas' => 'required|string|max:50',
            'nama' => 'required|string|max:50',
            'email' => 'required|email|max:50',
            'alamat' => 'required|string|max:50',
            'no_HP' => 'required|string|max:15',
            'angkatan' => 'required|string|max:4',
            'status' => 'required|string|max:15',
            'jalur_masuk' => 'required|string|max:10',
            'foto' => 'required|string|max:50',
            'kode_kota_kab' => 'required|string|max:4',
            'nama_doswal' => 'required|string|max:50',
            'persetujuan' => 'required|string|max:20',
        ];
    }

    public static function messages() {
        return [
            'nama.required' => 'Nama harus diisi.',
            'nama.max' => 'Nama maksimal 50 karakter.',
            'email.required' => 'Email harus diisi.',
            'alamat.required' => 'Alamat harus diisi.',
            'no_HP.required' => 'Nomor HP harus diisi.',
            'angkatan.required' => 'Angkatan harus diisi.',
            'status.required' => 'Status harus diisi.',
            'jalur_masuk.required' => 'Jalur masuk harus diisi.',
            'kode_kota_kab.required' => 'Kota/kabupaten harus diisi.',
        ];
    }

}
