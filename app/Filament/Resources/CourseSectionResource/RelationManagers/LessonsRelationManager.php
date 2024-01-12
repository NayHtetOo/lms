<?php

namespace App\Filament\Resources\CourseSectionResource\RelationManagers;

use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;

class LessonsRelationManager extends RelationManager
{
    protected static string $relationship = 'lessons';

    public function form(Form $form): Form
    {
        // dd($this);
        return $form
            ->schema([
                TextInput::make('course_id')
                    ->default('1')
                    ->readOnly()
                ,
                TextInput::make('lesson_name')
                    ->required()
                    ->maxLength(255),
                RichEditor::make('content')->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('lesson_name')
            ->columns([
                // Tables\Columns\TextColumn::make('course_id')->label('Course Name'),
                Tables\Columns\TextColumn::make('lesson_name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                // ->mutateFormDataUsing(function (array $data): array {
                //     // dd($data);
                //     return $data;
                // })
                // ->form([
                //     TextInput::make('course_id')
                //     ->default('1')
                //     ->readOnly(),
                //     TextInput::make('lesson_name')
                // ]),
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
