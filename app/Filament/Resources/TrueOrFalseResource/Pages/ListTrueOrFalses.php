<?php

namespace App\Filament\Resources\TrueOrFalseResource\Pages;

use App\Filament\Resources\TrueOrFalseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrueOrFalses extends ListRecords
{
    protected static string $resource = TrueOrFalseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
