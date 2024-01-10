<?php

namespace App\Filament\Resources\EssayResource\Pages;

use App\Filament\Resources\EssayResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEssay extends CreateRecord
{
    protected static string $resource = EssayResource::class;
}
