<?php

namespace App\Filament\Resources\MatchingResource\Pages;

use App\Filament\Resources\MatchingResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMatching extends ViewRecord
{
    protected static string $resource = MatchingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
