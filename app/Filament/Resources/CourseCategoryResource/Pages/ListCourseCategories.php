<?php

namespace App\Filament\Resources\CourseCategoryResource\Pages;

use Filament\Actions;
use App\Models\Course;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\CourseCategoryResource;
use App\Models\CourseCategory;

class ListCourseCategories extends ListRecords
{
    protected static string $resource = CourseCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
