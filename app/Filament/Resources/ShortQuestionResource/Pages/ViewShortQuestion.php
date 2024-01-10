<?php

namespace App\Filament\Resources\ShortQuestionResource\Pages;

use App\Filament\Resources\ShortQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewShortQuestion extends ViewRecord
{
    protected static string $resource = ShortQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
