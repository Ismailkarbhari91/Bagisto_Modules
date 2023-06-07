<?php
namespace Webkul\CsvCategory\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
/**
* HelloWorldServiceProvider
*
* @copyright 2020 Webkul Software Pvt. Ltd. (http://www.webkul.com)
*/
class CategoryUploadServiceProvider extends ServiceProvider
{
    /**
    * Bootstrap services.
    *
    * @return void
    */
    public function boot()
    {

        $this->loadRoutesFrom(__DIR__ . '/../Http/admin-routes.php');

        // $this->loadRoutesFrom(__DIR__ . '/../Http/shop-routes.php');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'csvcategory');
    }

    /**
    * Register services.
    *
    * @return void
    */
    public function register()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/admin-menu.php', 'menu.admin'
        );
    }
}
