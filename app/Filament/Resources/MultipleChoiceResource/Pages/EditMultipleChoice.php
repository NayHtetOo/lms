<?php

namespace App\Filament\Resources\MultipleChoiceResource\Pages;

use App\Filament\Resources\MultipleChoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMultipleChoice extends EditRecord
{
    protected static string $resource = MultipleChoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
