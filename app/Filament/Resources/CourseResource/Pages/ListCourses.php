<?php

namespace App\Filament\Resources\CourseResource\Pages;

use App\Filament\Resources\CourseResource;
use App\Filament\Resources\CourseResource\Widgets\CourseOverview;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ListCourses extends ListRecords
{
    protected static string $resource = CourseResource::class;

    protected static string $view = 'filament.resources.course.pages.list-course';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            CourseOverview::class,
        ];
    }

    public function getTabs():array{
        return [
            'all' => Tab::make(),
            'beginner'=> Tab::make(),
            'advance' => Tab::make()
        ];
    }
    public function getDefaultActiveTab(): string | int | null
    {
        return 'all';
    }
}
