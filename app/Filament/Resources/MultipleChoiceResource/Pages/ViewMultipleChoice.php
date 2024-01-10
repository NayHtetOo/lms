<?php

namespace App\Filament\Resources\MultipleChoiceResource\Pages;

use App\Filament\Resources\MultipleChoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMultipleChoice extends ViewRecord
{
    protected static string $resource = MultipleChoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
