<?php

namespace App\Filament\Resources\ExamResource\RelationManagers;

use Closure;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Resources\RelationManagers\RelationManager;

class ShortQuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'short_questions';

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
                RichEditor::make('question')->columnSpanFull()->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('question')
            ->columns([
                TextColumn::make('question_no')->label('No.')->searchable(),
                TextColumn::make('question')->searchable()->formatStateUsing(fn (string $state) => strip_tags($state)),
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
