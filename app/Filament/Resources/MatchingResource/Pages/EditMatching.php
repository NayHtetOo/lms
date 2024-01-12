<?php

namespace App\Filament\Resources\MatchingResource\Pages;

use App\Filament\Resources\MatchingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMatching extends EditRecord
{
    protected static string $resource = MatchingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
