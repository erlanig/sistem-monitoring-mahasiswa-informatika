<?php
namespace App\Imports;
use App\Models\User;
Use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $nama = $row['nama'];
        $email = $row['email'];
        $nim = $row['nim'];

        // Periksa apakah data 'email' ada dan valid
        if (!empty($email)) {

            $angkatan = $row['angkatan'];
            $angkatan = preg_replace("/[^0-9]/", "", $angkatan);
            $nim = preg_replace("/[^0-9]/", "", $nim);

            // Membuat catatan User
            $user = User::create([
                'nama'     => $nama,
                'email'    => $email,
                'password' => bcrypt($row['password']),
                'role'     => $row['role'],
            ]);

            // Membuat catatan Mahasiswa dan mengisi kolom lain
            $mahasiswa = new Mahasiswa([
                'user_id'     => $user->id,
                'nama'        => $nama,
                'email'       => $email,
                'nim'         => $nim,
                'fakultas'    => $row['fakultas'],
                'angkatan'    => $angkatan,
                'status'      => $row['status'],
                'jalur_masuk' => $row['jalur_masuk'],
                'nama_doswal' => $row['nama_doswal'],
            ]);
            $mahasiswa->save();
        }

        return null; // Return null jika data 'email' kosong atau tidak valid
    }
}
