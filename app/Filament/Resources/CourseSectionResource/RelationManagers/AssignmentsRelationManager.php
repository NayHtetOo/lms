<?php

namespace App\Filament\Resources\CourseSectionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;

class AssignmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'assignments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('course_id')->default($this->getOwnerRecord()->course_id),
                TextInput::make('assignment_name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('mark')
                    ->numeric()
                    ->required()
                    ->maxLength(3),
                RichEditor::make('description')->columnSpanFull()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('assignment_name')
            ->columns([
                TextColumn::make('No')->rowIndex(),
                TextColumn::make('assignment_name'),
                TextColumn::make('description')->formatStateUsing(fn (string $state) => strip_tags($state)),
                TextColumn::make('mark')->formatStateUsing(fn (string $state) => $state . " marks")
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
