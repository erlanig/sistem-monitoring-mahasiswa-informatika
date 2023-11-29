<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PKL extends Model
{
    protected $table = 'pkl';

    protected $primaryKey = 'id_pkl';

    public $timestamps = false;

    protected $fillable = [
        'id_pkl',
        'status_pkl',
        'nilai_pkl',
        'berkas_pkl',
        'id_mhs'
    ];
}
