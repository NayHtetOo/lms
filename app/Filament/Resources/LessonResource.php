<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LessonResource\Pages;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseSection;
use App\Models\Lesson;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Get;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions;
use Illuminate\Support\Collection;

class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // protected static ?string $navigationGroup = 'Group Items';
    protected static ?string $navigationGroup = 'Admin Management';

    protected static ?int $navigationSort = 4;

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()->schema([
                    // Select::make('course_id')->label('Course Name')->options([
                    //     'Beginner' => Course::join('course_categories as cc','cc.id','=','courses.course_category_id')
                    //         ->where('cc.category_name','beginner')
                    //         ->pluck('courses.course_name','courses.id')
                    //         ->toArray()
                    //     ,
                    //     'Advanced' => Course::join('course_categories as cc','cc.id','=','courses.course_category_id')
                    //         ->where('cc.category_name','advanced')
                    //         ->pluck('courses.course_name','courses.id')
                    //         ->toArray()
                    // ])
                    // ->required(),
                    // Select::make('course_section_id')->label('Section Name')->options(
                    //     fn(Get $get): Collection => CourseSection::query()->where('course_id',$get('course_id'))
                    //     ->pluck('section_name','id')
                    // )->searchable()
                    // ->preload()->live()->required(),
                    Select::make('course_id')->label('Course Name')->options(function () {
                        return Course::all()->pluck('course_name', 'id');
                    })->disabled(),
                    Select::make('course_section_id')->label('Section Name')->options(function () {
                        return CourseSection::all()->pluck('section_name', 'id');
                    })->disabled(),
                   TextInput::make('lesson_name')->required(),
                ])->columns(3),
                //     ->maxLength(65535)
                RichEditor::make('content')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // TextColumn::make('course_id'),
                TextColumn::make('course_id')->label('Course Name')
                    ->sortable()
                    ->getStateUsing(function($record){
                        $course = Course::find($record->course_id);
                        if($course){
                            return $course->course_name;
                        }else{
                            return '';
                        }
                    }),
                TextColumn::make('course_section_id')->label('Section Name')
                    ->sortable()
                    ->getStateUsing(function($record){
                        $courseSection = CourseSection::find($record->course_section_id);
                        if($courseSection){
                            return $courseSection->section_name;
                        }else{
                            return '';
                        }
                    })
                ,
                TextColumn::make('lesson_name')->label('Lesson Name')->toggleable()->searchable(),
                TextColumn::make('content')->toggleable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            \Filament\Infolists\Components\Grid::make()->schema([
                TextEntry::make('lesson_name')->label('Lesson Name'),
                TextEntry::make('class')->label('Class')->getStateUsing(function($record){
                    $course = CourseCategory::find(Course::find($record->course_id)->course_category_id);
                    return $course->category_name;
                }),
                TextEntry::make('course_id')->label('Course Name')->getStateUsing(function($record){
                    $course = Course::find($record->course_id);
                    return $course->course_name;
                }),
                TextEntry::make('course_section_id')->label('Section Name')->getStateUsing(function($record){
                    $section = CourseSection::find($record->course_section_id);
                    return $section->section_name;
                }),
            ])->columns(4),
            Fieldset::make('Content')->schema([
                TextEntry::make('content')->hiddenLabel()->columnSpanFull()
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
            'index' => Pages\ListLessons::route('/'),
            'create' => Pages\CreateLesson::route('/create'),
            'view' => Pages\ViewLesson::route('/{record}'),
            'edit' => Pages\EditLesson::route('/{record}/edit'),
        ];
    }
}
