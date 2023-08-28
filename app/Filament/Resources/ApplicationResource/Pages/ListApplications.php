<?php

namespace App\Filament\Resources\ApplicationResource\Pages;

use App\Filament\Resources\ApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListApplications extends ListRecords
{
    protected static string $resource = ApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => ListRecords\Tab::make('All'),
            'accepted' => ListRecords\Tab::make()->query(fn ($query) => $query->where('status', 'accepted')),
            'graduated' => ListRecords\Tab::make()->query(fn ($query) => $query->where('status', 'graduated')),
            'pending' => ListRecords\Tab::make()->query(fn ($query) => $query->where('status', 'pending')),
            'rejected' => ListRecords\Tab::make()->query(fn ($query) => $query->where('status', 'rejected')),
        ];
    }
}
