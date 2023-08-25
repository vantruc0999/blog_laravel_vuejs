<?php

namespace App\Filament\Resources\BloggerResource\Pages;

use App\Filament\Resources\BloggerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBlogger extends CreateRecord
{
    protected static string $resource = BloggerResource::class;
}
