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
        $courseCategory = courseCategory::with("courses")->get();
        $state = [];
        foreach ($courseCategory as $category) {
            $categories = $category->toArray();
            $state[] = Stat::make("", $categories["category_name"])
                ->description(count($categories["courses"]) . " created the course")
                ->color('primary');
        }

        return $state;
    }

    protected function getCards(): array
    {
        return [];
    }
}
