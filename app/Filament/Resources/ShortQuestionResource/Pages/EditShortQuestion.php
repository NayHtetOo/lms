<?php

namespace App\Filament\Resources\ShortQuestionResource\Pages;

use App\Filament\Resources\ShortQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShortQuestion extends EditRecord
{
    protected static string $resource = ShortQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
