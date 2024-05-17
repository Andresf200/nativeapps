<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

         \App\Models\Patient::factory(10)->create();

         \App\Models\Diagnostic::factory(10)->create();

         \App\Models\Patient::all()->each(function ($patient) {
             $diagnostics = \App\Models\Diagnostic::inRandomOrder()->take(3)->get();
             $patient->diagnostics()->attach($diagnostics->pluck('id')->toArray(), [
                 'observation' => 'Observation for patient',
                 'creation' => now()
             ]);
         });
    }
}
