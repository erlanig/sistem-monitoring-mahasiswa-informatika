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
                'nama'=>'Benny Ibrahim',
                'email'=>'benny@operator.undip.ac.id',
                'role'=>'operator',
                'password'=>bcrypt('adminadmin')
            ],
            // [
            //     'name'=>'Adhe Setya Pramayoga, S.Kom., M.T.',
            //     'email'=>'adhesetyapramayoga@lecturer.undip.ac.id',
            //     'role'=>'dosen',
            //     'password'=>bcrypt('adminadmin')
            // ],
        ];

        foreach($userData as $key => $val){
            User::create($val);
        }
    }
}
