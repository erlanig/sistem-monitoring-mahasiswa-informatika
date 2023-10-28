<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $table = 'dosen';

    protected $fillable = [
    'NIP',	
    'nama_doswal',	
    'email',
    'alamat',	
    'no_HP',
    'foto',
    ];
}
