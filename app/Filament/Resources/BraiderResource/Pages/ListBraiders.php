<?php

namespace App\Filament\Resources\BraiderResource\Pages;

use App\Filament\Resources\BraiderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBraiders extends ListRecords
{
    protected static string $resource = BraiderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
