<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BraiderResource\Pages;
use App\Filament\Resources\BraiderResource\RelationManagers;
use App\Models\Braider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class BraiderResource extends Resource
{
    protected static ?string $model = Braider::class;

    protected static ?string $navigationIcon = 'heroicon-o-scissors';
    protected static ?string $navigationLabel = 'Braiders';
    protected static ?string $navigationGroup = 'Braiders';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('bio')
                    ->required(),
                FileUpload::make('headshot')
                    ->directory('form-attachments')
                    ->preserveFilenames()
                    //->image()
                    ->imageEditor()
                    ->required(),
                FileUpload::make('work_image1')
                    ->label('Work Photo 1')
                    ->directory('form-attachments')
                    ->preserveFilenames()
                    //->image()
                    ->imageEditor()
                    ->required(),
                FileUpload::make('work_image2')
                    ->label('Work Photo 2')
                    ->directory('form-attachments')
                    ->preserveFilenames()
                    //->image()
                    ->imageEditor()
                    ->required(),
                FileUpload::make('work_image3')
                    ->label('Work Photo 3')
                    ->directory('form-attachments')
                    ->preserveFilenames()
                    //->image()
                    ->imageEditor()
                    ->required(),
                TextInput::make('min_price')
                    ->numeric()
                    ->minValue(1)
                    ->required(),
                TextInput::make('max_price')
                    ->numeric()
                    ->maxValue(4000)
                    ->gt('min_price')
                    ->required(),
                Toggle::make('verified')
                    ->default(true),
                Toggle::make('share_email')
                    ->default(false)
                    ->helperText('Switch this to true if you want your email to be displayed so that students can reach out to schedule appointments at unlisted times')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('headshot'),
                TextColumn::make('user.name'),
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
            'index' => Pages\ListBraiders::route('/'),
            'create' => Pages\CreateBraider::route('/create'),
            'edit' => Pages\EditBraider::route('/{record}/edit'),
        ];
    }
}
