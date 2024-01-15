<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseSectionResource\Pages;
use App\Filament\Resources\CourseSectionResource\RelationManagers\AssignmentsRelationManager;
use App\Filament\Resources\CourseSectionResource\RelationManagers\ExamsRelationManager;
use App\Filament\Resources\CourseSectionResource\RelationManagers\LessonsRelationManager;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseSection;
use App\Models\Essay;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use App\Models\Exam;
use App\Models\Lesson;
use App\Models\MultipleChoice;
use App\Models\ShortQuestion;
use App\Models\TrueOrFalse;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class CourseSectionResource extends Resource
{
    protected static ?string $model = CourseSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Sections';

    protected static ?string $navigationGroup = 'Admin Management';

    protected static ?int $navigationSort = 3;

    public static int $course_id = 1;

    // public static function getUrl($action, $parameters = [])
    // {
    //     return static::route($action, $parameters);
    // }

    public static function form(Form $form): Form
    {

        return $form->schema([
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
            // // ->afterStateUpdated(fn(Set $set) => $set('section_name',null))
            // ->preload()
            // ->live()
            // ->required()
            // ,
            // Select::make('course_id')->label('Course Name')->options(function () {
            //     return Course::all()->pluck('course_name', 'id');
            // })->disabled(),
            TextInput::make('section_name'),
        ]);
    }

    // public static function getEloquentQuery(): EloquentBuilder
    // {
    //     return parent::getEloquentQuery()->where('course_id','=','1');
    // }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('index')->label('No.')->state(
                    static function (Tables\Contracts\HasTable $livewire, \stdClass $rowLoop): string {
                        return (string) (
                            $rowLoop->iteration +
                            ($livewire->getTableRecordsPerPage() * (
                                $livewire->getTablePage() - 1
                            ))
                        );
                    }
                ),
                TextColumn::make('class')->getStateUsing(function($record){
                    $course = Course::find($record->course_id);
                    $courseCategory = CourseCategory::find($course->course_category_id);
                    return $courseCategory->category_name;
                }),
                TextColumn::make('section_name')->label('Section Name')
                    ->searchable(),
                TextColumn::make('course_id')->label('Course Name')
                    ->sortable()->getStateUsing(function($record){
                        $course = Course::find($record->course_id);
                        if($course){
                            return $course->course_name;
                        }else{
                            return '';
                        }
                    }
                ),
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            Grid::make()->schema([
                TextEntry::make('course_id')->label('Course Name')->getStateUsing(function($record){
                    $course = Course::find($record->course_id);
                    if($course){
                        return $course->course_name;
                    }else{
                        return '';
                    }
                }),
                TextEntry::make('section_name')->label('Section Name'),
                TextEntry::make('class')->getStateUsing(function($record){
                    $course = Course::find($record->course_id);
                    $courseCategory = CourseCategory::find($course->course_category_id);
                    return $courseCategory->category_name;
                }),
            ])->columns(3),
            RepeatableEntry::make('lessons')
                ->getStateUsing(function ($record) {
                    // dd($record->course_id,$record->id);
                    $lessons = Lesson::where('course_id',$record->course_id)->where('course_section_id',$record->id)->get();
                    return $lessons;
                })
                ->schema([
                    Grid::make()->schema([
                        TextEntry::make('lesson_name')->label('Lesson Name')->getStateUsing(function ($record) {
                            return $record->lesson_name;
                        })
                        ->badge()->color('info')
                        ->columnSpan(1),
                        TextEntry::make('content')->getStateUsing(function($record){
                            return $record->content;
                        })->color('gray')
                        ->columnSpan(4)
                    ])->columns(5)
                ])
                ->columns(2)->columnSpanFull(),
            RepeatableEntry::make('exams')->getStateUsing(function($record){
                $data = Exam::where('course_id',$record->course_id)->where('course_section_id',$record->id)->get();
                return $data;
            })->schema([
                Grid::make()->schema([
                    TextEntry::make('exam_name')->label('Exam Name')->getStateUsing(function($record){
                        return $record->exam_name;
                    }),
                    TextEntry::make('start_date_time')->label('Start Date Time')->getStateUsing(function($record){
                        return $record->start_date_time;
                    }),
                    TextEntry::make('end_date_time')->label('End Date Time')->getStateUsing(function($record){
                        return $record->end_date_time;
                    }),
                    TextEntry::make('duration')->getStateUsing(function($record){
                        return $record->duration.' minutes';
                    })
                ])->columns(4)->columnSpanFull(),
                Fieldset::make('Description')->schema([
                    TextEntry::make('description')->hiddenLabel()->getStateUsing(function($record){
                        return $record->description;
                    })->columnSpanFull(),
                ]),
                Fieldset::make('True or False Question')->schema([
                    RepeatableEntry::make('question')->hiddenLabel()
                        ->getStateUsing(function($record){
                            $question = TrueOrFalse::where('exam_id',$record->id)->get();
                            // dd($question->toArray());
                            return $question;
                        })->schema([
                            \Filament\Infolists\Components\Grid::make()->schema([
                                TextEntry::make('question')
                                ->getStateUsing(function($record){
                                    return $record->question;
                                })
                                ->hiddenLabel()
                                // ->badge()->color('primary')
                                ->columnSpan(3),
                                TextEntry::make('answer')
                                    ->getStateUsing(function($record){
                                        return 'Answer: '.$record->answer;
                                    })
                                    ->hiddenLabel()
                                    ->badge()->color('success')
                                ,
                                \Filament\Infolists\Components\Grid::make()->schema([])->columnSpan(4),
                            ]),
                    ])->columnSpanFull()
                ]),
                Fieldset::make('Multiple Choice Question')->schema([
                    RepeatableEntry::make('multiple_question')->hiddenLabel()->label('Multiple Choice Question')->getStateUsing(function($record){
                        $data = MultipleChoice::where('exam_id',$record->id)->get();
                        return $data;
                    })->schema([
                        \Filament\Infolists\Components\Grid::make()->schema([
                            TextEntry::make('question')->getStateUsing(function($record){
                                return $record->question;
                            })->hiddenLabel()->columnSpan(3),
                            TextEntry::make('answer')->getStateUsing(function($record){
                                $answer = $record->answer == 1 ? 'A' : ( $record->answer == 2 ? 'B' : ($record->answer == 3 ? 'C' : 'D'));
                                return 'Answer: '.$answer;
                            })->hiddenLabel()->badge()->color('success'),

                            \Filament\Infolists\Components\Grid::make()->schema([
                                TextEntry::make('choice_1')->getStateUsing(function($record){
                                    return '(A) '.$record->choice_1;
                                })->hiddenLabel()
                                ,
                                TextEntry::make('choice_2')->getStateUsing(function($record){
                                    return '(B) '.$record->choice_2;
                                })->hiddenLabel()
                                ,
                                TextEntry::make('choice_3')->getStateUsing(function($record){
                                    return '(C) '.$record->choice_3;
                                })->hiddenLabel()
                                ,
                                TextEntry::make('choice_4')->getStateUsing(function($record){
                                    return '(D) '.$record->choice_4;
                                })->hiddenLabel()
                                ,
                            ])->columnSpan(4)
                        ])
                        // ->columnSpanFull()
                    ])
                    ->columnSpanFull()
                ]),
                // Short Question Block
                Fieldset::make('Short Questions')->schema([
                    RepeatableEntry::make('short_question')->hiddenLabel()->getStateUsing(function($record){
                        $data = ShortQuestion::where('exam_id',$record->id)->get();
                        return $data;
                    })->schema([
                        TextEntry::make('question')->hiddenLabel()->getStateUsing(function($record){
                            return $record->question;
                        })
                    ])->columnSpanFull()
                ]),
                // Essay Block
                Fieldset::make('Essays')->schema([
                    RepeatableEntry::make('essay')->hiddenLabel()->getStateUsing(function($record){
                        $data = Essay::where('exam_id',$record->id)->get();
                        return $data;
                    })->schema([
                        TextEntry::make('question')->hiddenLabel()->getStateUsing(function($record){
                            return $record->question;
                        })
                    ])->columnSpanFull()
                ])

            ])->columnSpanFull(),
        ]);
        // return ViewEntry::make('section_name')->view('resources.views.infolists.components.course-section-switcher');
    }

    public static function getRelations(): array
    {
        // dd($courseId);
        return [
            // LessonsRelationManager::make([
            //     'status' => 'approved'
            // ]),
            LessonsRelationManager::class,
            ExamsRelationManager::class,
            // CoursesRelationManager::class
            AssignmentsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourseSections::route('/'),
            'create' => Pages\CreateCourseSection::route('/create'),
            'view' => Pages\ViewCourseSection::route('/{record}'),
            'edit' => Pages\EditCourseSection::route('/{record}/edit'),
        ];
    }
}
