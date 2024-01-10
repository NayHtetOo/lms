<?php

namespace App\Infolists\Components;

use Filament\Infolists\Components\Entry;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;

class CourseSectionSwitcher extends Entry
{
    protected string $view = 'infolists.components.course-section-switcher';

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            TextEntry::make('course_name'),
            TextEntry::make('section_name'),

        ]);
    }
}
