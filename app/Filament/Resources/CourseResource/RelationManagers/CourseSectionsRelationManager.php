<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use App\Filament\Resources\CourseResource;
use App\Filament\Resources\CourseSectionResource;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class CourseSectionsRelationManager extends RelationManager
{
    protected static string $relationship = 'course_sections';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('section_name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('section_name')
            ->columns([
                Tables\Columns\TextColumn::make('section_name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\EditAction::make()
                    ->url(fn (Model $record): string =>
                    CourseSectionResource::getUrl('edit',[$record])),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    public static function getPages(): array
    {
        return [
            // 'index' => Pages\CourseSection::route('/'),
            // 'create' => Pages\CreateRole::route('/create'),
            // 'view' => Pages\ViewRole::route('/{record}'),
            // 'edit' => \App\Filament\Resources\CourseSectionResource\Pages\EditCourseSection::route('/{record}/edit'),
        ];
    }
}
