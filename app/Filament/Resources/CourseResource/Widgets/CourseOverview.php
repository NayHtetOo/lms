<?php

namespace App\Filament\Resources\CourseResource\Widgets;

use App\Models\Course;
use App\Models\CourseCategory;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\DB;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class CourseOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $courseCategory = CourseCategory::select()
                        ->leftJoin('course_categories', 'courses.course_category_id', 'course_categories.id')
                        ->groupBy('courses.course_category_id')
                        ->get();
        dd($courseCategory);
        $state = [];
        // foreach ($courses->toArray() as $course) {
        //     $state[] = Stat::make($course['count'] . ' courses created', $course['category_name']);
        // }

        return $state;
    }

    protected function getCards(): array
    {
        return [];
    }
}
