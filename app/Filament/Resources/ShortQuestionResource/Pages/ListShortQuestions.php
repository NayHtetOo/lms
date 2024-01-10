<?php

namespace App\Filament\Resources\ShortQuestionResource\Pages;

use App\Filament\Resources\ShortQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShortQuestions extends ListRecords
{
    protected static string $resource = ShortQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
