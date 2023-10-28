<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'name'=>'Erlan Irhab Ghalib',
                'email'=>'erlan@students.undip.ad.id',
                'role'=>'mahasiswa',
                'password'=>bcrypt('adminadmin')
            ],
        ];

        foreach($userData as $key => $val){
            User::create($val);
        }
    }
}
