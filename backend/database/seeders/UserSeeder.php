<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [    
                'name'      => 'Mindo Fanbregas Sitorus',
                'email'     => 'admin@gmail.com',
                'password'  => Hash::make('password123'),
                'role'      => 'admin',
                'no_hp'     => '081234567890',
                'alamat'    => 'Bandung, Jawa Barat',
            ],
            [
                'name'      => 'Nazriel Nur Apriliansyah',
                'email'     => 'petugas@gmail.com',
                'password'  => Hash::make('password123'),
                'role'      => 'petugas',
                'no_hp'     => '082345678901',
                'alamat'    => 'Bandung, Jawa Barat',
            ],
            [
                'name'      => 'Rasya Pradana Putra',
                'email'     => 'rasya@gmail.com',
                'password'  => Hash::make('password123'),
                'role'      => 'peminjam',
                'no_hp'     => '083456789012',
                'alamat'    => 'Bandung, Jawa Barat',
            ],
            [
                'name'      => 'Dimas Raditya Putranto',
                'email'     => 'dimas@gmail.com',
                'password'  => Hash::make('password123'),
                'role'      => 'peminjam',
                'no_hp'     => '084567890123',
                'alamat'    => 'Bandung, Jawa Barat',
            ],
            [
                'name'      => 'Alif Yudha Fauzan',
                'email'     => 'alif@gmail.com',
                'password'  => Hash::make('password123'),
                'role'      => 'peminjam',
                'no_hp'     => '085678901234',
                'alamat'    => 'Bandung, Jawa Barat',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
