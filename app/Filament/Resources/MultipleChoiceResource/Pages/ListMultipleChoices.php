<?php

namespace App\Filament\Resources\MultipleChoiceResource\Pages;

use App\Filament\Resources\MultipleChoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMultipleChoices extends ListRecords
{
    protected static string $resource = MultipleChoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
