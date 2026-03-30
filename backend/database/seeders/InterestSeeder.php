<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Interest;

class InterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $interests = ['DevOps', 'Full Stack', 'Back End', 'Front End', 'Laravel'];
        foreach ($interests as $interest) {
            Interest::firstOrCreate(['name' => $interest]);
        }
    }
}
