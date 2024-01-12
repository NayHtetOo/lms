<?php

namespace App\Filament\Resources\ExamResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;

class MatchingsRelationManager extends RelationManager
{
    protected static string $relationship = 'matchings';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('question_no'),
                TextInput::make('mark')->numeric(),
                Textarea::make('question')->columnSpanFull()->required(),
                RichEditor::make('question_1')->columnSpanFull()->required(),
                TextInput::make('answer_1')->required(),
                RichEditor::make('question_2')->columnSpanFull()->required(),
                TextInput::make('answer_2')->required(),
                RichEditor::make('question_3')->columnSpanFull()->required(),
                TextInput::make('answer_3')->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('question')
            ->columns([
                Tables\Columns\TextColumn::make('question_no')->label('No.')->searchable(),
                Tables\Columns\TextColumn::make('question'),
                Tables\Columns\TextColumn::make('mark'),
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
