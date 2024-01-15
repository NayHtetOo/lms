<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Filament\Resources\CourseResource\RelationManagers\CourseSectionsRelationManager;
use App\Filament\Resources\CourseResource\RelationManagers\EnrollmentsRelationManager;
use App\Filament\Resources\CourseResource\Widgets\CourseOverview;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseSection;
use App\Models\Exam;
use App\Models\Lesson;
use Filament\Facades\Filament;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Admin Management';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        // return static::getModel()::where('status','=','available')->count();
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('course_category_id')->label('Category Type')->required()->options(
                   CourseCategory::all()->pluck('category_name','id')
                ),
                TextInput::make('course_name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('course_idd')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('from_date')
                    ->required(),
                DatePicker::make('to_date')
                    ->required(),
                Toggle::make('visible')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('index')->label('No.')->state(
                    static function (\Filament\Tables\Contracts\HasTable $livewire, \stdClass $rowLoop): string {
                        return (string) (
                            $rowLoop->iteration +
                            ($livewire->getTableRecordsPerPage() * (
                                $livewire->getTablePage() - 1
                            ))
                        );
                    }
                ),
                TextColumn::make('course_category_id')->label('Class')
                    ->getStateUsing(function($record) {
                        $courseCategory = CourseCategory::find($record->course_category_id);
                        if($courseCategory){
                            return $courseCategory->category_name;
                        }else{
                            return 'No Category';
                        }
                    }
                    )
                ,
                TextColumn::make('course_name')->label('Course Name')
                    ->searchable(),
                TextColumn::make('course_id')->label('Course ID')
                    ->searchable(),
                TextColumn::make('description')->toggleable(),
                TextColumn::make('from_date')->label('From Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('to_date')->label('To Date')
                    ->date()
                    ->sortable(),
                IconColumn::make('visible')
                    ->boolean(),
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
                Actions\DeleteAction::make()
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
                TextEntry::make('course_category_id')->label('Class')->getStateUsing(function($record){
                    $courseCategory = CourseCategory::find($record->course_category_id);
                    return $courseCategory->category_name;
                }),
                TextEntry::make('course_id')->label('Course ID')->getStateUsing(function($record){
                    return $record->course_id;
                }),
                TextEntry::make('course_name')->getStateUsing(function($record){
                    return $record->course_name;
                }),
                TextEntry::make('from_date')->label('From Date')->getStateUsing(function($record){
                    return $record->from_date;
                }),
                TextEntry::make('to_date')->label('To Date')->getStateUsing(function($record){
                    return $record->to_date;
                }),
                TextEntry::make('visible')->label('Status')->getStateUsing(function($record){
                    return $record->visible == 1 ? 'Visible' : 'Invisible';
                }),
            ])->columns(5),
            Fieldset::make('Description')->schema([
                TextEntry::make('description')->hiddenLabel()->getStateUsing(function($record){
                    return $record->description;
                })
                ->columnSpanFull(),
            ]),
            Fieldset::make('Sections')->schema([
                RepeatableEntry::make('')->getStateUsing(function($record){
                    $section = CourseSection::where('course_id',$record->id)->get();
                    return $section;
                })->schema([
                    TextEntry::make('section_name')->label('Section Name')
                        ->getStateUsing(function($record){
                            return $record->section_name;
                        })
                    ,
                    RepeatableEntry::make('')->getStateUsing(function($record){
                        $lesson = Lesson::where('course_id',$record->course_id)->where('course_section_id',$record->id)->get();
                        return $lesson;
                    })->schema([
                        TextEntry::make('lesson')->label('Lesson')->getStateUsing(function($record){
                           return $record->lesson_name;
                        })->columns(1),
                        TextEntry::make('content')->label('Content')->getStateUsing(function($record){
                            return $record->content;
                         })->columnSpanFull(4),
                    ]),
                    // exam
                    RepeatableEntry::make('')->getStateUsing(function($record){
                        $exam = Exam::where('course_id',$record->course_id)->where('course_section_id',$record->id)->get();
                        return $exam;
                    })->schema([
                        TextEntry::make('exam')->label('Exam')->getStateUsing(function($record){
                           return $record->exam_name;
                        })->columns(1),
                        TextEntry::make('description')->label('description')->getStateUsing(function($record){
                            return $record->description;
                         })->columnSpanFull(4),
                        // question block
                        //  RepeatableEntry::make('Ture or False Questions')->getStateUsing(function($record){
                        //     $trueorfalse = TrueOrFalse::where('exam_id',$record->id)->get();
                        //     return $trueorfalse;
                        //  })
                        //  ->schema([
                        //     TextEntry::make('question')->getStateUsing(function($record){
                        //         return $record->question;
                        //     }),
                        //     TextEntry::make('answer')->getStateUsing(function($record){
                        //         return $record->answer;
                        //     })
                        //  ])
                    ]),
                ])->columnSpanFull(),
            ]),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            CourseSectionsRelationManager::class,
            EnrollmentsRelationManager::class
        ];
    }

    public static function getWidgets(): array
    {
        return [
            CourseOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'view' => Pages\ViewCourse::route('/{record}'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
