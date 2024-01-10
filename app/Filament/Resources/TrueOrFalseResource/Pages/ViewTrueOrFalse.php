<?php

namespace App\Filament\Resources\TrueOrFalseResource\Pages;

use App\Filament\Resources\TrueOrFalseResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTrueOrFalse extends ViewRecord
{
    protected static string $resource = TrueOrFalseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
