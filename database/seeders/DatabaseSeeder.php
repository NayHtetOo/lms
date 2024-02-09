<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseSection;
use App\Models\Exam;
use App\Models\Grade;
use App\Models\TrueOrFalse;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \App\Models\Admin::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123')
        ]);
        // \App\Models\CourseMember::factory(30)->create();
        $list = ['admin', 'teacher', 'student','guest'];

        for ($i = 0; $i < count($list); $i++) {
            \App\Models\Role::create([
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

        CourseCategory::factory(3)->has(Course::factory(3),'courses')->create();

        Course::factory(3)
            ->has(CourseSection::factory()->count(3), 'course_sections')
            ->has(Exam::factory()->count(2),'exams')
        ->create();

        Exam::factory(3)->has(TrueOrFalse::factory()->count(10),'true_or_falses')
        ->create();

    }
}
