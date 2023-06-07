<?php 

namespace Webkul\Quote\Providers;

 use Illuminate\Support\ServiceProvider;
 use Illuminate\Support\Facades\Event;

 
 class QuoteServiceProvider extends ServiceProvider
 {
     /**
     * Bootstrap services.
     *
     * @return void
     */
     public function boot()
     {
          include __DIR__ . '/../Http/routes.php';
          $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'quote_view');
          $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'quote_lang');
          $this->loadMigrationsFrom(__DIR__ .'/../Database/Migrations');

     }

     /**
     * Register services.
     *
     * @return void
     */
     public function register()
     {
          $this->mergeConfigFrom(dirname(__DIR__) . '/../Config/menu.php', 'menu.admin');
          $this->mergeConfigFrom(dirname(__DIR__) . '/../Config/acl.php', 'acl');
     }
 }