<?php
namespace Database\Seeders;
 
use App\Models\User;
use Illuminate\Database\Seeder;
 
class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin Desa',
            'email'    => 'admin@desa.id',
            'password' => bcrypt('password123'),
            'role'     => 'admin',
        ]);
 
        User::create([
            'name'     => 'Kepala Desa',
            'email'    => 'kades@desa.id',
            'password' => bcrypt('password123'),
            'role'     => 'kades',
        ]);
 
        User::create([
            'name'     => 'Staff Administrasi',
            'email'    => 'staff@desa.id',
            'password' => bcrypt('password123'),
            'role'     => 'staff',
        ]);
    }
}
