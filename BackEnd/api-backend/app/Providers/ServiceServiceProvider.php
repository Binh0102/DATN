<?php

namespace App\Providers;

use App\Services\Cart\CartService;
use App\Services\Cart\CartServiceEloquent;
use App\Services\Category\CategoryService;
use App\Services\Category\CategoryServiceEloquent;
use App\Services\Comment\CommentService;
use App\Services\Comment\CommentServiceEloquent;
use App\Services\CommentImage\CommentImageService;
use App\Services\CommentImage\CommentImageServiceEloquent;
use App\Services\Favorite\FavoriteService;
use App\Services\Favorite\FavoriteServiceEloquent;
use App\Services\Image\ImageService;
use App\Services\Image\ImageServiceEloquent;
use App\Services\Order\OrderService;
use App\Services\Order\OrderServiceEloquent;
use App\Services\OrderDetail\OrderDetailService;
use App\Services\OrderDetail\OrderDetailServiceEloquent;
use App\Services\Product\ProductService;
use App\Services\Product\ProductServiceEloquent;
use App\Services\ProductVariant\ProductVariantService;
use App\Services\ProductVariant\ProductVariantServiceEloquent;
use App\Services\User\UserService;
use App\Services\User\UserServiceEloquent;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(UserService::class, UserServiceEloquent::class);
        $this->app->singleton(CategoryService::class, CategoryServiceEloquent::class);
        $this->app->singleton(ProductService::class, ProductServiceEloquent::class);
        $this->app->singleton(CartService::class, CartServiceEloquent::class);
        $this->app->singleton(FavoriteService::class, FavoriteServiceEloquent::class);
        $this->app->singleton(CommentService::class, CommentServiceEloquent::class);
        $this->app->singleton(CommentImageService::class, CommentImageServiceEloquent::class);
        $this->app->singleton(ProductVariantService::class, ProductVariantServiceEloquent::class);
        $this->app->singleton(OrderService::class, OrderServiceEloquent::class);
        $this->app->singleton(OrderDetailService::class, OrderDetailServiceEloquent::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
