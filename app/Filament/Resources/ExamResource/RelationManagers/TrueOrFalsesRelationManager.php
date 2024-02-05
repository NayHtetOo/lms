<?php

namespace App\Filament\Resources\ExamResource\RelationManagers;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;

class TrueOrFalsesRelationManager extends RelationManager
{
    protected static string $relationship = 'true_or_falses';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('question_no'),
                TextInput::make('mark')->numeric(),
                RichEditor::make('question')->columnSpanFull()->required(),
                Select::make('answer')->options([
                    '1' => 'True',
                    '0' => 'False',
                ])->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('question')
            ->columns([
                TextColumn::make('question_no')->label('No.')->searchable(),
                TextColumn::make('question'),
                TextColumn::make('answer')->getStateUsing(function ($record) {
                    $answer = $record->answer == '1' ? 'True' : 'False';
                    return $answer;
                }),
                TextColumn::make('mark'),
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
