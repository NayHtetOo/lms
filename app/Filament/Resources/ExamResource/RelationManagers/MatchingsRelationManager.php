<?php

namespace App\Filament\Resources\ExamResource\RelationManagers;

use Closure;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class MatchingsRelationManager extends RelationManager
{
    protected static string $relationship = 'matchings';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('question_no'),
                TextInput::make('mark')->numeric()->rules([
                    function () {
                        return function (string $attribute, $value, Closure $fail) {
                            if ($value > 100 || $value < 0) {
                                $fail("The :attribute is invalid and maark field must be between 0 and 100");
                            }
                        };
                    }
                ]),
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
                Tables\Columns\TextColumn::make('question')->limit(10),
                TextColumn::make('question_1')->limit(10)->formatStateUsing(fn (string $state) => strip_tags($state)),
                TextColumn::make('question_2')->limit(10)->formatStateUsing(fn (string $state) => strip_tags($state)),
                TextColumn::make('question_3')->limit(10)->formatStateUsing(fn (string $state) => strip_tags($state)),
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
