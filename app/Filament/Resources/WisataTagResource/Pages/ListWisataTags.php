<?php

namespace App\Filament\Resources\WisataTagResource\Pages;

use App\Filament\Resources\WisataTagResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWisataTags extends ListRecords
{
    protected static string $resource = WisataTagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
