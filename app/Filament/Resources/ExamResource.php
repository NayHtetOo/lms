<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExamResource\Pages;
use App\Filament\Resources\ExamResource\RelationManagers\EssaysRelationManager;
use App\Filament\Resources\ExamResource\RelationManagers\ForumsRelationManager;
use App\Filament\Resources\ExamResource\RelationManagers\MatchingsRelationManager;
use App\Filament\Resources\ExamResource\RelationManagers\MultipleChoicesRelationManager;
use App\Filament\Resources\ExamResource\RelationManagers\ShortQuestionsRelationManager;
use App\Filament\Resources\ExamResource\RelationManagers\TrueOrFalsesRelationManager;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseSection;
use App\Models\Essay;
use App\Models\Exam;
use App\Models\MultipleChoice;
use App\Models\ShortQuestion;
use App\Models\TrueOrFalse;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Tables\Columns\TextColumn;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Pages\Page;
use Illuminate\Support\Facades\App;

class ExamResource extends Resource
{
    protected static ?string $model = Exam::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Admin Management';

    protected static ?int $navigationSort = 5;

    // protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::End;

    // public static function getRecordSubNavigation(Page $page) :array{
    //     return $page->generateNavigationItems([
    //         Pages\ListExams::class,
    //         Pages\ViewExam::class,
    //         \App\Filament\Resources\LessonResource\Pages\CreateLesson::class,
    //         Pages\EditExam::class
    //     ]);
    // }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make()->schema([
                TextInput::make('exam_name')->required(),
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
                // ->afterStateUpdated(fn(Set $set) => $set('course_section_id',null))
                // ->preload()
                // ->live()
                // ->required()
                // ,
                // Select::make('course_section_id')->label('Section Name')
                //     ->options(
                //         // CourseSection::all()->pluck('section_name','id')
                //         fn(Get $get): Collection => CourseSection::query()
                //         ->where('course_id',$get('course_id'))
                //         ->pluck('section_name','id')
                //     )->searchable()
                //     ->preload()
                //     // ->live()
                //     ->required()
                // ,
                Select::make('course_id')->label('Course Name')->options(function () {
                    return Course::all()->pluck('course_name', 'id');
                })->disabled(),
                Select::make('course_section_id')->label('Section Name')->options(function () {
                    return CourseSection::all()->pluck('section_name', 'id');
                })->disabled(),
            ])->columns(3),
            Grid::make()->schema([
                // TextInput::make('exam_name')->required(),
                DateTimePicker::make('start_date_time')
                    ->required(),
                DateTimePicker::make('end_date_time')
                    ->required(),
                TextInput::make('duration')->label('Duration(minutes)')
                    ->required()
                    ->numeric(),
            ])->columns(3),
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
                    static function (Tables\Contracts\HasTable $livewire, \stdClass $rowLoop): string {
                        return (string) (
                            $rowLoop->iteration +
                            ($livewire->getTableRecordsPerPage() * (
                                $livewire->getTablePage() - 1
                            ))
                        );
                    }
                ),
                // TextColumn::make('course_id')->label('Course Name')
                //     ->sortable()
                //     ->getStateUsing(function($record){
                //         $course = Course::find($record->course_id);
                //         if($course){
                //             return $course->course_name;
                //         }else{
                //             return '';
                //         }
                //     }),
                // TextColumn::make('course_section_id')->label('Section Name')
                //     ->sortable()
                //     ->getStateUsing(function($record){
                //         $courseSection = CourseSection::find($record->course_id);
                //         if($courseSection){
                //             return $courseSection->section_name;
                //         }else{
                //             return '';
                //         }
                //     })
                // ,

                TextColumn::make('exam_name')->label('Exam Name')->searchable(),
                TextColumn::make('start_date_time')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('end_date_time')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('duration')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('description'),
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
            Fieldset::make('Exam Information')->schema([
                \Filament\Infolists\Components\Grid::make()->schema([
                    TextEntry::make('exam_name')->label('Exam Name'),
                    TextEntry::make('class')->label('Class')->getStateUsing(function($record){
                        $course = CourseCategory::find(Course::find($record->course_id)->course_category_id);
                        return $course->category_name;
                    }),
                    TextEntry::make('course_id')->label('Course Name')->getStateUsing(function($record){
                        $course = Course::find($record->course_id);
                        if($course){
                            return $course->course_name;
                        }else{
                            return '';
                        }
                    }),
                    TextEntry::make('course_section_id')->label('Course Section Name')->getStateUsing(function($record){
                        $course = CourseSection::find($record->course_section_id);
                        if($course){
                            return $course->section_name;
                        }else{
                            return '';
                        }
                    }),
                ])->columns(4),
                \Filament\Infolists\Components\Grid::make()->schema([

                    TextEntry::make('start_date_time')->label('Start Date Time'),
                    TextEntry::make('end_date_time')->label('End Date Time'),
                    TextEntry::make('duration')->label('Duration')->getStateUsing(function($record){
                        return $record->duration.' Minutes';
                    }),
                ])->columns(4),
            ]),
            Fieldset::make('Description')->schema([
                TextEntry::make('description')->hiddenLabel()->columnSpanFull(),
            ]),
            // True or False Questions Block
            Fieldset::make('True or False Questions')->schema([
                RepeatableEntry::make('true_false_question')->hiddenLabel()->label('True or False Question')->getStateUsing(function($record){
                    $data = TrueOrFalse::where('exam_id',$record->id)->get();
                    return $data;
                })->schema([
                    \Filament\Infolists\Components\Grid::make()->schema([
                        TextEntry::make('question')->getStateUsing(function($record){
                            return $record->question? $record->question :'No Q';
                        })->hiddenLabel()
                        ->columnSpan(3),
                        TextEntry::make('answer')->getStateUsing(function($record){
                            return 'Answer: '.$record->answer;
                        })
                        ->hiddenLabel()
                        ->badge()->color('success'),
                        \Filament\Infolists\Components\Grid::make()->schema([])->columnSpan(4),
                    ])
                ])->columnSpanFull(),
            ]),
            // Multiple Choice Questions Block
            Fieldset::make('Multiple Choice Questions')->schema([
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
        ]);
    }

    public static function getRelations(): array
    {
        return [
            TrueOrFalsesRelationManager::class,
            MultipleChoicesRelationManager::class,
            MatchingsRelationManager::class,
            ShortQuestionsRelationManager::class,
            EssaysRelationManager::class,
            ForumsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExams::route('/'),
            'create' => Pages\CreateExam::route('/create'),
            'view' => Pages\ViewExam::route('/{record}'),
            'edit' => Pages\EditExam::route('/{record}/edit'),
        ];
    }
}
