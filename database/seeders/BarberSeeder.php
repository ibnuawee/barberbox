<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Barber;

class BarberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = User::where('role', 'barber')->whereNotIn('id', Barber::pluck('user_id'))->get();

        foreach ($users as $user) {
            Barber::create([
                'user_id' => $user->id,
                // Tambahkan kolom-kolom lain yang sesuai di sini
            ]);
        }

        $barbers = Barber::all();

        foreach ($barbers as $barber) {
            $user = $barber->user;

            if ($user && $user->role !== 'barber') {
                $barber->delete(); // Hapus data barber jika pengguna tidak lagi memiliki peran 'barber'
            }
        }
    }
    
}
