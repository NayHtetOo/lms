<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentColor;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Colors\Color;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        FilamentColor::register([
           'danger' => Color::Red,
           'gray' => Color::Zinc,
           'info' => Color::Blue,
           'primary' => Color::Amber,
           'success' => Color::Green,
           'warning' => Color::Amber,
           'indigo' => Color::Indigo,
           'danger_color' => Color::hex('#ff0000'),// #ff0000->danger , #4bf542->green
        ]);
    }
}
