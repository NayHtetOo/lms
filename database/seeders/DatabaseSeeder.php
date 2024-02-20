<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseSection;
use App\Models\Exam;
use App\Models\Grade;
use App\Models\Role;
use App\Models\TrueOrFalse;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Admin::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123')
        ]);

        $users = [
            [
                'name' => 'nay',
                'email' => 'nay@gmail.com',
                'password' => bcrypt('123'),
            ],
            [
                'name' => 'htet',
                'email' => 'htet@gmail.com',
                'password' => bcrypt('123'),
            ],
            [
                'name' => 'oo',
                'email' => 'oo@gmail.com',
                'password' => bcrypt('123'),
            ],
            [
                'name' => 'merlin',
                'email' => 'merlin@gmail.com',
                'password' => bcrypt('123'),
            ]
        ];

        foreach($users as $user){
            User::create($user);
        }

        $list = ['admin', 'teacher', 'student','guest'];

        for ($i = 0; $i < count($list); $i++) {
            Role::create([
                'name' => $list[$i]
            ]);
        }
        // create grades seeder
        $grade = ['A','B','C','D'];
        $mark = ['80,100','60,80','40,60','20,40'];

        foreach($grade as $key => $g){
            Grade::create([
                'name' => $g,
                'mark' => $mark[$key]
            ]);
        }

        CourseCategory::factory(3)->has(Course::factory(2),'courses')->create();

        Course::factory(2)
            ->has(CourseSection::factory()->count(2), 'course_sections')
            ->has(Exam::factory()->count(1),'exams')
        ->create();

        Exam::factory(2)->has(TrueOrFalse::factory()->count(10),'true_or_falses')
        ->create();

    }
}
