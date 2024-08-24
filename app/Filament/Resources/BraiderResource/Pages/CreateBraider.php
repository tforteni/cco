<?php

namespace App\Filament\Resources\BraiderResource\Pages;

use App\Filament\Resources\BraiderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateBraider extends CreateRecord
{
    protected static string $resource = BraiderResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $braider = static::getModel()::create($data);
        $braider->user->update([
            'role' => 'braider'
        ]);

        return $braider;
    }
}
