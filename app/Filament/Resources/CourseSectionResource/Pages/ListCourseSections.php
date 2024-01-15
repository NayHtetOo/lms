<?php

namespace App\Filament\Resources\CourseSectionResource\Pages;

use App\Filament\Resources\CourseSectionResource;
use Filament\Resources\Pages\ListRecords;

class ListCourseSections extends ListRecords
{
    protected static string $resource = CourseSectionResource::class;

    protected static ?string $title = "All Sections";

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make()->label('Add Course Section'),
        ];
    }
}
