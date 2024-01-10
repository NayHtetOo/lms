<?php

namespace App\Filament\Resources\CourseResource\Widgets;

use App\Models\Course;
use App\Models\CourseCategory;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget\Card;

class CourseOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $beginner = Course::join('course_categories as cc','cc.id','=','courses.course_category_id')
            ->where('cc.category_name','beginner')->count();
        $advanced = Course::join('course_categories as cc','cc.id','=','courses.course_category_id')
            ->where('cc.category_name','advanced')->count();

        return[
            Card::make('All Course',Course::all()->count()),
            Card::make('Beginner Class',$beginner),
            Card::make('Advanced Class',$advanced)
        ];
    }
    protected function getCards(): array
    {
       return [];
    }
}
