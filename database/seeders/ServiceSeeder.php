<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $services = ['Haircut', 'Perm', 'Smoothing', 'Coloring'];
        
        foreach ($services as $service) {
            Service::create(['name' => $service]);
        }
    }
}
