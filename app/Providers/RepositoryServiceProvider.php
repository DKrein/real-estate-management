<?php

namespace App\Providers;

use App\Repositories\BuildingRepository;
use App\Repositories\CommentRepository;
use App\Repositories\Interface\BuildingRepositoryInterface;
use App\Repositories\Interface\CommentRepositoryInterface;
use App\Repositories\Interface\TaskRepositoryInterface;
use App\Repositories\TaskRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BuildingRepositoryInterface::class, BuildingRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
