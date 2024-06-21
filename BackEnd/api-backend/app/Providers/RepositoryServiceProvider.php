<?php

namespace App\Providers;

use App\Repositories\Cart\CartRepository;
use App\Repositories\Cart\CartRepositoryEloquent;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryEloquent;
use App\Repositories\Comment\CommentRepository;
use App\Repositories\Comment\CommentRepositoryEloquent;
use App\Repositories\CommentImage\CommentImageRepository;
use App\Repositories\CommentImage\CommentImageRepositoryEloquent;
use App\Repositories\Favorite\FavoriteRepository;
use App\Repositories\Favorite\FavoriteRepositoryEloquent;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Order\OrderRepositoryEloquent;
use App\Repositories\OrderDetail\OrderDetailRepository;
use App\Repositories\OrderDetail\OrderDetailRepositoryEloquent;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryEloquent;
use App\Repositories\ProductVariant\ProductVariantRepository;
use App\Repositories\ProductVariant\ProductVariantRepositoryEloquent;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(UserRepository::class, UserRepositoryEloquent::class);
        $this->app->singleton(CategoryRepository::class, CategoryRepositoryEloquent::class);
        $this->app->singleton(ProductRepository::class, ProductRepositoryEloquent::class);
        $this->app->singleton(FavoriteRepository::class, FavoriteRepositoryEloquent::class);
        $this->app->singleton(CartRepository::class, CartRepositoryEloquent::class);
        $this->app->singleton(CommentRepository::class, CommentRepositoryEloquent::class);
        $this->app->singleton(ProductVariantRepository::class, ProductVariantRepositoryEloquent::class);
        $this->app->singleton(CommentImageRepository::class, CommentImageRepositoryEloquent::class);
        $this->app->singleton(OrderRepository::class, OrderRepositoryEloquent::class);
        $this->app->singleton(OrderDetailRepository::class, OrderDetailRepositoryEloquent::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
