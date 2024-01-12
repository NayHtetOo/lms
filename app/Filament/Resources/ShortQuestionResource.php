<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShortQuestionResource\Pages;
use App\Filament\Resources\ShortQuestionResource\RelationManagers;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseSection;
use App\Models\Exam;
use App\Models\ShortQuestion;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rules\In;

class ShortQuestionResource extends Resource
{
    protected static ?string $model = ShortQuestion::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Questions';

    protected static ?int $navigationSort = 4;

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('exam_id')->label('Exam ID')
                ->id('exId')
                ->options( function(){
                        $exam = Exam::all()->pluck('exam_name','id')->toArray();
                        return $exam;
                    }
                )
                ->preload()
                ->live()
                ->required(),
                TextInput::make('question_no')->label('Question No'),
                Forms\Components\Textarea::make('question')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question_no')->label('No.')->searchable()->sortable(),
                TextColumn::make('question')->searchable(),
                TextColumn::make('exam_id')->label('Exam Name')
                    ->numeric()
                    ->sortable()
                    ->getStateUsing(function($record){
                        $exam = Exam::find($record->exam_id);
                        // dd($exam->toArray());
                        if($exam){
                            return $exam->exam_name;
                        }else{
                            return '';
                        }
                })->toggleable(),
                TextColumn::make('course_id')->label('Course Name')
                    ->sortable()
                    ->getStateUsing(function($record){
                        // dd($record->toArray());
                        return Course::find(Exam::find($record->exam_id)->course_id)->course_name;
                })->toggleable(),
                TextColumn::make('course_section_id')->label('Section Name')
                    ->sortable()
                    ->getStateUsing(function($record){
                        return CourseSection::find(Exam::find($record->exam_id)->course_section_id)->section_name;
                })->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            TextEntry::make('question')->label('Short Question')->columnSpanFull(),
            Fieldset::make('Short Question Information')->schema([
                \Filament\Infolists\Components\Grid::make()->schema([
                    TextEntry::make('exam_name')->getStateUsing(function($record){
                        $exam = Exam::find($record->exam_id);
                        return $exam->exam_name;
                    })->columnSpan(3),
                    TextEntry::make('class')->getStateUsing(function($record){
                        $exam = Exam::find($record->exam_id);
                        $course = CourseCategory::find(Course::find($exam->course_id)->course_category_id);
                        return $course->category_name;
                    })->columnSpan(2),
                    TextEntry::make('course_name')->getStateUsing(function($record){
                        $exam = Exam::find($record->exam_id);
                        $course = Course::find($exam->course_id);
                        return $course->course_name;
                    })->columnSpan(4),
                    TextEntry::make('section_name')->getStateUsing(function($record){
                        $exam = Exam::find($record->exam_id);
                        $section = CourseSection::find($exam->course_section_id);
                        return $section->section_name;
                    })->columnSpan(4),
                ])->columns(13),
            ]),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShortQuestions::route('/'),
            'create' => Pages\CreateShortQuestion::route('/create'),
            'view' => Pages\ViewShortQuestion::route('/{record}'),
            'edit' => Pages\EditShortQuestion::route('/{record}/edit'),
        ];
    }
}
