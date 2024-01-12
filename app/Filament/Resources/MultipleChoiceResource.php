<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MultipleChoiceResource\Pages;
use App\Filament\Resources\MultipleChoiceResource\RelationManagers;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseSection;
use App\Models\Exam;
use App\Models\MultipleChoice;
use Filament\Forms;
use Filament\Forms\Components\Grid;
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

class MultipleChoiceResource extends Resource
{
    protected static ?string $model = MultipleChoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Questions';

    protected static ?int $navigationSort = 2;

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()->schema([
                    Select::make('exam_id')->label('Exam Name')
                    ->options( function(){
                            $exam = Exam::all()->pluck('exam_name','id')->toArray();
                            return $exam;
                        }
                    )
                    ->preload()
                    ->live()
                    ->required(),
                    TextInput::make('question_no')->label('Question No')
                ])->columns(3),
                Forms\Components\RichEditor::make('question')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Grid::make()->schema([
                    Forms\Components\TextInput::make('choice_1')->label('A')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('choice_2')->label('B')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('choice_3')->label('C')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('choice_4')->label('D')
                        ->required()
                        ->maxLength(255),
                    // Forms\Components\TextInput::make('answer')
                    //     ->required()
                    //     ->numeric(),
                    Select::make('answer')->options([
                        1 => 'A',
                        2 => 'B',
                        3 => 'C',
                        4 => 'D'
                    ])->required()
                ])->columns(5),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question_no')->label('No.'),
                TextColumn::make('question'),
                Tables\Columns\TextColumn::make('choice_1')->label('A')
                    ->searchable(),
                Tables\Columns\TextColumn::make('choice_2')->label('B')
                    ->searchable(),
                Tables\Columns\TextColumn::make('choice_3')->label('C')
                    ->searchable(),
                Tables\Columns\TextColumn::make('choice_4')->label('D')
                    ->searchable(),
                TextColumn::make('answer')->getStateUsing(function($record){
                    return $record->answer == 1 ? 'A' : ($record->answer == 2 ? 'B' : ($record->answer == 3 ? 'C' : 'D'));
                })->alignCenter(),
                TextColumn::make('exam_id')
                    ->numeric()
                    ->sortable()
                    ->getStateUsing(function($record){
                        $exam = Exam::find($record->exam_id);
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
                    })->toggleable()
                ,
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
            \Filament\Infolists\Components\Grid::make()->schema([
                TextEntry::make('question_no')->label('No.')->columnSpan(2),
                TextEntry::make('question')->columnSpan(18),
                TextEntry::make('answer')->badge()->color('success')
                ->getStateUsing(function($record){
                    return $record->answer == 1 ? 'A' : ($record->answer == 2 ? 'B' :($record->answer == 3 ? 'C' : 'D'));
                })->columnSpan(2)
                ,
            ])->columns(22),
            \Filament\Infolists\Components\Grid::make()->schema([
                TextEntry::make('choice_1')
                    ->hiddenLabel()
                    ->getStateUsing(function($record){
                        return '(A) '.$record->choice_1;
                    }
                ),
                TextEntry::make('choice_2')
                    ->hiddenLabel()
                ->getStateUsing(function($record){
                    return '(B) '.$record->choice_2;
                }),
                TextEntry::make('choice_3')
                    ->hiddenLabel()
                ->getStateUsing(function($record){
                    return '(C) '.$record->choice_3;
                }),
                TextEntry::make('choice_4')
                    ->hiddenLabel()
                ->getStateUsing(function($record){
                    return '(D) '.$record->choice_4;
                }),
            ])->columns(4),
            Fieldset::make('Multiple Choice Information')->schema([
                \Filament\Infolists\Components\Grid::make()->schema([
                    TextEntry::make('exam_name')->getStateUsing(function($record){
                        $exam = Exam::find($record->exam_id);
                        return $exam->exam_name;
                    })->columnSpan(3),
                    TextEntry::make('class')->label('Class')->getStateUsing(function($record){
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
            'index' => Pages\ListMultipleChoices::route('/'),
            'create' => Pages\CreateMultipleChoice::route('/create'),
            'view' => Pages\ViewMultipleChoice::route('/{record}'),
            'edit' => Pages\EditMultipleChoice::route('/{record}/edit'),
        ];
    }
}
