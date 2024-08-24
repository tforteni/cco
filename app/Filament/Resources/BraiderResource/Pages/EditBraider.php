<?php

namespace App\Filament\Resources\BraiderResource\Pages;

use App\Filament\Resources\BraiderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBraider extends EditRecord
{
    protected static string $resource = BraiderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
