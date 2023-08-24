<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;

use App\Contract\Admin\LikeInterface;
use App\Contract\Admin\BeatInterface;
use App\Contract\Admin\PostInterface;
use App\Contract\Admin\UserInterface;
use App\Repository\Admin\UserRepository;



use App\Repository\Admin\LikeRepository;
use App\Repository\Admin\BeatRepository;
use App\Repository\Admin\PostRepository;


/**
 * Class RepositoryServiceProvider
 * @package App\Providers
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */


         public function register()
         {

        $this->app->bind(LikeInterface::class, LikeRepository::class);
        $this->app->bind(BeatInterface::class, BeatRepository::class);
        $this->app->bind(PostInterface::class, PostRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);

         }
}