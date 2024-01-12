<?php

namespace App\Filament\Resources\ForumResource\Pages;

use App\Filament\Resources\ForumResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListForums extends ListRecords
{
    protected static string $resource = ForumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
