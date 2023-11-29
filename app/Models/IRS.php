<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IRS extends Model
{
    protected $table = 'irs';

    protected $primaryKey = 'id_irs';

    public $timestamps = false;


    protected $fillable = [
        'id_irs',	
        'smst_aktif',	
        'jumlah_sks',	
        'berkas_irs',	
        'status_irs',	
        'id_mhs',
        'NIM',
        'persetujuan'
    ];

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'NIM', 'NIM');
    }

}