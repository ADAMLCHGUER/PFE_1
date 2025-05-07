<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\ScheduleServiceProvider::class,
    App\Providers\MiddlewareServiceProvider::class, // Nouveau service provider pour middleware
    Barryvdh\DomPDF\ServiceProvider::class,
    App\Providers\RouteServiceProvider::class,
];