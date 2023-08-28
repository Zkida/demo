<?php

namespace App\Filament\Resources\ApplicationResource\Pages;

use Filament\Actions;
use Illuminate\Support\Str;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\ApplicationResource;

class EditApplication extends EditRecord
{
    protected static string $resource = ApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

}
