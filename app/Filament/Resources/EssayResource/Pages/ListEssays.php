<?php

namespace App\Filament\Resources\EssayResource\Pages;

use App\Filament\Resources\EssayResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEssays extends ListRecords
{
    protected static string $resource = EssayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
