<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KHS extends Model
{
    protected $table = 'khs';

    protected $primaryKey = 'id_khs';

    public $timestamps = false;

    protected $fillable = [
        'id_khs',
        'SKS_semester',
        'SKS_kumulatif',
        'IP_smt',
        'IP_kumulatif',
        'berkas_khs',
        'status_khs',
        'id_mhs'
    ];
}
