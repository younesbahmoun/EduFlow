<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\CourseRepositoryInterface;
use App\Repositories\CourseRepository;
use App\Interfaces\WishlistRepositoryInterface;
use App\Repositories\WishlistRepository;
use App\Interfaces\EnrollmentRepositoryInterface;
use App\Repositories\EnrollmentRepository;
use App\Interfaces\GroupRepositoryInterface;
use App\Repositories\GroupRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CourseRepositoryInterface::class, CourseRepository::class);
        $this->app->bind(WishlistRepositoryInterface::class, WishlistRepository::class);
        $this->app->bind(EnrollmentRepositoryInterface::class, EnrollmentRepository::class);
        $this->app->bind(GroupRepositoryInterface::class, GroupRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
