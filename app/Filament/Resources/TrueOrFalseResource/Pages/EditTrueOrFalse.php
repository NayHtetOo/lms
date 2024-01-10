<?php

namespace App\Filament\Resources\TrueOrFalseResource\Pages;

use App\Filament\Resources\TrueOrFalseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrueOrFalse extends EditRecord
{
    protected static string $resource = TrueOrFalseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
