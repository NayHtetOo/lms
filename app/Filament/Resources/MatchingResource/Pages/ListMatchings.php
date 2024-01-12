<?php

namespace App\Filament\Resources\MatchingResource\Pages;

use App\Filament\Resources\MatchingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMatchings extends ListRecords
{
    protected static string $resource = MatchingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
