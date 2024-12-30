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
        // Ensure the 'bio' field has a default value if not provided
        $data['bio'] = $data['bio'] ?? ''; // Use an empty string as the default value for 'bio'

        $braider = static::getModel()::create($data);

        // Update the related user role to 'braider'
        $braider->user->update([
            'role' => 'braider',
        ]);

        return $braider;
    }
}

