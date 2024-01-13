<?php

namespace App\Filament\Resources\CourseSectionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;

class ExamsRelationManager extends RelationManager
{
    protected static string $relationship = 'exams';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // TextInput::make('course_id')->label('Course Name')
                //     ->required()
                //     ->default('1')
                //     ->readOnly()
                //     ->maxLength(255)
                // ,
                Hidden::make('course_id')->default($this->getOwnerRecord()->course_id),
                TextInput::make('exam_name')
                    ->required()
                    ->maxLength(255)
                ,
                TextInput::make('duration')->label('Duration (minutes)')
                    ->required()
                    ->maxLength(255)
                ,
                DateTimePicker::make('start_date_time')
                    ->required(),
                DateTimePicker::make('end_date_time')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull()
                ,
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('exam_name')
            ->columns([
                TextColumn::make('exam_name')->searchable(),
                TextColumn::make('duration')->label('Duration (minutes)'),
                TextColumn::make('description'),
                TextColumn::make('start_date_time'),
                TextColumn::make('end_date_time'),
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
