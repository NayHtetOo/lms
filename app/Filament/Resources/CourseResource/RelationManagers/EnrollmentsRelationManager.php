<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use App\Filament\Resources\CourseResource\Pages\EditCourse;
use App\Models\Role;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class EnrollmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'enrollments';

    // protected static string $title = 'aa';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')->label('User')->required()->options(
                    User::all()->pluck('name','id')
                 ),
                 Select::make('role_id')->label('Role')->required()->options(
                    Role::all()->pluck('name','id')
                 ),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Participants')
            ->recordTitleAttribute('status')
            ->columns([
                TextColumn::make('user_id')->label('Username')
                    ->getStateUsing(function($record) {
                        $user = User::find($record->user_id);
                        if($user){
                            return $user->name;
                        }else{
                            return 'No Name';
                        }
                    }
                ),
                TextColumn::make('email')->label('Email')
                    ->getStateUsing(function($record) {
                        $user = User::find($record->user_id);
                        if($user){
                            return $user->email;
                        }else{
                            return 'No Email';
                        }
                    }
                ),
                TextColumn::make('role_id')->label('Role')
                    ->getStateUsing(function($record) {
                        $role = Role::find($record->role_id);
                        if($role){
                            return $role->name;
                        }else{
                            return 'No Role';
                        }
                    }
                ),
                TextColumn::make('status'),
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
    public static function getRelations(): array
    {
        return [
            EnrollmentsRelationManager::class
        ];
    }
    public static function getPages(): array
    {
        return [
            'edit' => EditCourse::route('/{record}/edit'),
        ];
    }

}
