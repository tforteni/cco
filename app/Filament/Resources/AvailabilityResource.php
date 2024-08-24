<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AvailabilityResource\Pages;
use App\Filament\Resources\AvailabilityResource\RelationManagers;
use App\Models\Availability;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use App\Enums\DayEnum;
use App\Models\User;
use Filament\Tables\Columns\TextColumn;

class AvailabilityResource extends Resource
{
    protected static ?string $model = Availability::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Availability';
    protected static ?string $navigationGroup = 'Braiders';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('braider_id')
                    ->relationship('braider.user', 'name', function ($query) {
                            $query->where('role', 'braider');
                })
                    ->required(),
                Select::make('day')
                    ->options([
                        'Monday' => DayEnum::MONDAY->value,
                        'Tuesday' => DayEnum::TUESDAY->value,
                        'Wednesday' => DayEnum::WEDNESDAY->value,
                        'Thursday' => DayEnum::THURSDAY->value,
                        'Friday' => DayEnum::FRIDAY->value,
                        'Saturday' => DayEnum::SATURDAY->value,
                        'Sunday' => DayEnum::SUNDAY->value,
                    ])
                    ->required(),
                Select::make('start_time')
                    ->options([
                        '6' => '6:00AM',
                        '7' => '7:00AM',
                        '8' => '8:00AM',
                        '9' => '9:00AM',
                        '10' => '10:00AM',
                        '11' => '11:00AM',
                        '12' => '12:00PM',
                        '13' => '1:00PM',
                        '14' => '2:00PM',
                        '15' => '3:00PM',
                        '16' => '4:00PM',
                        '17' => '5:00PM',
                        '18' => '6:00PM',
                        '19' => '7:00PM',
                        '20' => '8:00PM',
                        '21' => '9:00PM',
                        '22' => '10:00PM',
                        '23' => '11:00PM',
                    ]),
                Select::make('end_time')
                ->options([
                    '7' => '7:00AM',
                    '8' => '8:00AM',
                    '9' => '9:00AM',
                    '10' => '10:00AM',
                    '11' => '11:00AM',
                    '12' => '12:00PM',
                    '13' => '1:00PM',
                    '14' => '2:00PM',
                    '15' => '3:00PM',
                    '16' => '4:00PM',
                    '17' => '5:00PM',
                    '18' => '6:00PM',
                    '19' => '7:00PM',
                    '20' => '8:00PM',
                    '21' => '9:00PM',
                    '22' => '10:00PM',
                    '23' => '11:00PM',
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('braider.user.name'),
                TextColumn::make('day'),
                TextColumn::make('start_time'),
                TextColumn::make('end_time'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAvailabilities::route('/'),
            'create' => Pages\CreateAvailability::route('/create'),
            'edit' => Pages\EditAvailability::route('/{record}/edit'),
        ];
    }
}
