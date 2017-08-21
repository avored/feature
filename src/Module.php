<?php

namespace Mage2\Feature;

use Illuminate\Support\Facades\View;
use Mage2\Framework\Support\BaseModule;
use Mage2\Framework\Module\Facades\Module as ModuleFacade;
use Illuminate\Support\Facades\File;
use Symfony\Component\Yaml\Yaml;

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
