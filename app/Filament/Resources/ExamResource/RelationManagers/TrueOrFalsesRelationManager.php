<?php

namespace App\Filament\Resources\ExamResource\RelationManagers;

use Closure;
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
                TextColumn::make('question')->formatStateUsing(fn (string $state) => strip_tags($state)),
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
