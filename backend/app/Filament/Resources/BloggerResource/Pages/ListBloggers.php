<?php

namespace App\Filament\Resources\BloggerResource\Pages;

use App\Filament\Resources\BloggerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBloggers extends ListRecords
{
    protected static string $resource = BloggerResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
