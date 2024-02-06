<?php

namespace App\Filament\Resources\ExamResource\RelationManagers;

use Closure;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class MultipleChoicesRelationManager extends RelationManager
{
    protected static string $relationship = 'multiple_choices';

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
                Grid::make()->schema([
                    TextInput::make('choice_1')->label('A')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('choice_2')->label('B')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('choice_3')->label('C')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('choice_4')->label('D')
                        ->required()
                        ->maxLength(255),
                    Select::make('answer')->label('Correct Answer')->options([
                        1 => 'A',
                        2 => 'B',
                        3 => 'C',
                        4 => 'D'
                    ])->required()
                ])->columns(5),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('question')
            ->columns([
                TextColumn::make('question_no')->label('No.')->searchable(),
                TextColumn::make('question')->formatStateUsing(fn (string $state) => strip_tags($state)),
                TextColumn::make('choice_1')->label('A'),
                TextColumn::make('choice_2')->label('B'),
                TextColumn::make('choice_3')->label('C'),
                TextColumn::make('choice_4')->label('D'),
                TextColumn::make('answer')
                    ->getStateUsing(function($record){
                        $answer = ($record->answer == 1 ? 'A' :
                            ($record->answer == 2 ? 'B' :
                                ($record->answer == 3 ? 'C' : 'D')
                            )
                        );
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
