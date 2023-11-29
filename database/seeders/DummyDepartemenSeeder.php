<?php

namespace Database\Seeders;

use App\Models\Departemen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyDepartemenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'NIP'=> '234304012010053123',
                'nama'=>'Mulya Irwansyah, S.Kom',
                'email'=>'omul@departement.undip.ac.id',
                'alamat'=>'Jalan Viltem',
                'no_HP'=>'0832231311',
                'fakultas'=>'Sains dan Matematika',
            ],
        ];

        foreach($userData as $key => $val){
            Departemen::create($val);
        }
    }
}
