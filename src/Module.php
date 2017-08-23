<?php

namespace Mage2\Feature;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Mage2\Feature\Listeners\FeatureProductSavingListener;
use Mage2\Framework\Support\BaseModule;
use Mage2\Feature\ViewComposers\BasicFieldViewComposer;
use Mage2\Product\Events\ProductSavedEvent;

class Module extends BaseModule
{

    /**
     *
     * Module Name Variable
     * @var string $name
     *
     */
    protected $name = NULL;

    /**
     *
     * Module identifier  Variable
     * @var string $identifier
     *
     */
    protected $identifier = NULL;
    /**
     *
     * Module Description Variable
     * @var string $description
     *
     */
    protected $description = NULL;


    /**
     *
     * Module Enable Variable
     * @var bool $enable
     *
     */
    protected $enable = NULL;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (true === $this->getEnable()) {
            //$this->registerModule();
            $this->registerDatabasePath();
            $this->registerViewComposerData();
            $this->registerModuleListener();
        }

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerModuleYamlFile(__DIR__ . DIRECTORY_SEPARATOR . 'module.yaml');

        if (true === $this->getEnable()) {
            $this->mapWebRoutes();
            $this->registerViewPath();
        }
    }


    public function registerViewComposerData() {
        View::composer('mage2-product::product.card.basic', BasicFieldViewComposer::class);
    }
    public function registerDatabasePath()
    {
        $this->loadMigrationsFrom(__DIR__ . "/../database/migrations");
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        $this->loadRoutesFrom(__DIR__ ."/../routes/web.php");
    }

    /**
     *
     * Register Event Listeners
     *
     * @return void
     */

    public function registerModuleListener()
    {
        Event::listen(ProductSavedEvent::class, FeatureProductSavingListener::class);
    }
    /**
     * add path to view finder.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    protected function registerViewPath()
    {
        $this->loadViewsFrom(__DIR__ ."/../resources/views", "mage2-feature");
    }

}
