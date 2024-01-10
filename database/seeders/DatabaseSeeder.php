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
        //     'name' => 'Admin',
        //     'email' => 'admin@gmail.com',
        // ]);
        
        // \App\Models\User::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => bcrypt('123')
        // ]);
        $list = ['admin', 'teacher', 'student','guest'];

        for ($i = 0; $i < count($list); $i++) {
            \App\Models\Role::create([
                'name' => $list[$i]
            ]);
        }

    }
}
