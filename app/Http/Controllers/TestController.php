<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperatorController extends Controller
{
    function index()
    {
        echo "Halaman Home";
        echo "<h1>". Auth::user()->name ."</h1>";
        echo "<a href='/logout'>Logout >></a>";
    }

    function operator()
    {
        echo "Halaman Operator";
        echo "<h1>". Auth::user()->name ."</h1>";
        echo "<a href='/logout'>Logout >></a>";
    }

    function dosen()
    {
        echo "Halaman Dosen";
        echo "<h1>". Auth::user()->name ."</h1>";
        echo "<a href='/logout'>Logout >></a>";
    }

    function departemen()
    {
        echo "Halaman Departemen";
        echo "<h1>". Auth::user()->name ."</h1>";
        echo "<a href='/logout'>Logout >></a>";
    }

    function mahasiswa()
    {
        echo "Halaman Mahasiswa";
        echo "<h1>". Auth::user()->name ."</h1>";
        echo "<a href='/logout'>Logout >></a>";
    }
}
