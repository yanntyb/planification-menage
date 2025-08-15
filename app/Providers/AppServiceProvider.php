<?php

declare(strict_types=1);

namespace App\Providers;

use Carbon\CarbonImmutable;
use Date;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
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
        Date::use(CarbonImmutable::class);
        JsonResource::withoutWrapping();
    }
}
