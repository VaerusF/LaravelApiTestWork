<?php

namespace App\Infrastructure\Providers;

use App\Core\Domain\Entities\Comment\ICommentRepository;
use App\Core\Domain\Entities\Company\ICompanyRepository;
use App\Core\Domain\Entities\File\IFilesRepository;
use App\Core\Domain\Entities\User\IUserRepository;
use App\Infrastructure\Persistence\Repositories\CommentRepository;
use App\Infrastructure\Persistence\Repositories\CompanyRepository;
use App\Infrastructure\Persistence\Repositories\FilesRepository;
use App\Infrastructure\Persistence\Repositories\UserRepository;
use App\Infrastructure\Services\FileDiskManagerService;
use App\Infrastructure\Services\IFileDiskManagerService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IFilesRepository::class, FilesRepository::class);
        $this->app->bind(ICompanyRepository::class, CompanyRepository::class);
        $this->app->bind(ICommentRepository::class, CommentRepository::class);
        $this->app->bind(IFileDiskManagerService::class, FileDiskManagerService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
