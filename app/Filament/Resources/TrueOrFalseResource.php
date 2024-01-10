<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrueOrFalseResource\Pages;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseSection;
use App\Models\Exam;
use App\Models\TrueOrFalse;
use Filament\Facades\Filament;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\Grid as ComponentsGrid;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions;


class TrueOrFalseResource extends Resource
{
    protected static ?string $model = TrueOrFalse::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Ture or False';

    protected static ?string $navigationGroup = 'Questions';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()->schema([
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
                    TextInput::make('question_no'),
                    // TextInput::make('exam_name')->required()->readOnly(),
                    // Select::make('course_id')->label('Course Name')->options(
                    //     Course::all()->pluck('course_name','id')
                    // )->searchable()
                    // ->afterStateUpdated(fn(Set $set) => $set('course_section_id',null))
                    // ->preload()
                    // ->live()
                    // ->required(),
                    // Select::make('course_section_id')->label('Section Name')->options(
                    //     fn(Get $get): Collection => CourseSection::query()->where('course_id',$get('course_id'))
                    //     ->pluck('section_name','id')
                    // )->searchable()
                    // ->preload()->live()->required(),
                ])->columns(3),
                RichEditor::make('question')->columnSpanFull()->required(),
                Select::make('answer')->options([
                    'true' => 'True',
                    'false' => 'False',
                ])->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question_no')->label('Question No.')->searchable()->sortable(),
                TextColumn::make('question')->searchable(),
                TextColumn::make('answer')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('exam_id')->label('Exam Name')
                    ->numeric()
                    ->sortable()
                    ->toggleable()
                    ->getStateUsing(function($record){
                        $exam = Exam::find($record->exam_id);
                        // dd($exam->toArray());
                        if($exam){
                            return $exam->exam_name;
                        }else{
                            return '';
                        }
                }),
                TextColumn::make('course_id')->label('Course Name')
                    // ->sortable()
                    ->toggleable()
                    ->getStateUsing(function($record){
                        // dd($record->toArray());
                        return Course::find(Exam::find($record->exam_id)->course_id)->course_name;
                    }),
                TextColumn::make('course_section_id')->label('Section Name')
                    // ->sortable()
                    ->toggleable()
                    ->getStateUsing(function($record){
                        return CourseSection::find(Exam::find($record->exam_id)->course_section_id)->section_name;
                    })
                ,
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
                TextEntry::make('question_no')->label('No.')->columnSpan(2),
                TextEntry::make('question')->columnSpan(18),
                TextEntry::make('answer')->badge()->color('success')->columnSpan(2)
            ])->columns(22),
            Fieldset::make('Question Information')->schema([
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
            'index' => Pages\ListTrueOrFalses::route('/'),
            'create' => Pages\CreateTrueOrFalse::route('/create'),
            'view' => Pages\ViewTrueOrFalse::route('/{record}'),
            'edit' => Pages\EditTrueOrFalse::route('/{record}/edit'),
        ];
    }
}
