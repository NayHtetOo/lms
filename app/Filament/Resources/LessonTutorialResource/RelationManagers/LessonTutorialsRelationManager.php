<?php

namespace App\Filament\Resources\LessonTutorialResource\RelationManagers;

use App\Tables\Columns\VideoColumn;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LessonTutorialsRelationManager extends RelationManager
{
    protected static string $relationship = 'lesson_tutorials';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)->schema([
                    Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Select::make('source_type')->label('Source From')->options([
                    'local' => 'Local Video',
                    'external' => 'Youtube Video',
                ])
                ->live()
                ->afterStateUpdated(fn (Select $component) => $component
                    ->getContainer()
                    ->getComponent('dynamicTypeFields')
                    ->getChildComponentContainer()
                    ->fill()
                ),
                Grid::make()
                    ->schema(fn (Get $get): array => match ($get('source_type')) {
                        'local' => [
                            FileUpload::make('path')->label('Upload')
                                ->directory('lesson_videos')
                        ],
                        'external' => [
                            TextInput::make('path')->label('Video Link')->placeholder('Enter Youtube Video Link')->rules('required','url'),
                        ],
                        default => [],
                    })
                    ->key('dynamicTypeFields')

                ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                // Tables\Columns\TextColumn::make('path')
                VideoColumn::make('path'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
