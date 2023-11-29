<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    protected $table = 'departemen';

    protected $fillable = [
        'NIP',
        'nama',
        'email',
        'alamat',
        'no_HP',
        'fakultas',
        'foto',];

    public $timestamps = false;
}
