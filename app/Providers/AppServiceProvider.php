<?php

namespace App\Providers;

use App\Enums\LegislationRelationshipType;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;

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
        Str::macro('highlightPhrase', function ($input, $searchString) {
            return str_ireplace($searchString, "<mark>$searchString</mark>", $input);
        });

        Collection::macro('byType', function (string $type) {
            return $this->filter(function ($value) use ($type) {
                return $value->type->value == $type;
            });
        });

        // Deteksi perangkat mobile
        $isMobile = request()->header('User-Agent') && preg_match('/Mobile|Android|iPhone/i', request()->header('User-Agent'));

        // Bagikan variabel ke semua view
        View::share('isMobile', $isMobile);
    }
}
