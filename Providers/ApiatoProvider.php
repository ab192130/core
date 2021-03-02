<?php

namespace Apiato\Core\Providers;

use Apiato\Core\Abstracts\Events\Providers\EventServiceProvider;
use Apiato\Core\Abstracts\Providers\MainProvider as AbstractMainProvider;
use Apiato\Core\Foundation\Apiato;
use Apiato\Core\Loaders\AutoLoaderTrait;
use Apiato\Core\Traits\ValidationTrait;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;

class ApiatoProvider extends AbstractMainProvider
{
    use AutoLoaderTrait;
    use ValidationTrait;

    public function boot(): void
    {
        parent::boot();

        // Autoload most of the Containers and Ship Components
        $this->runLoadersBoot();

        // Solves the "specified key was too long" error, introduced in L5.4
        Schema::defaultStringLength(191);

        // Registering custom validation rules
        $this->extendValidationRules();
    }

    public function register(): void
    {
        parent::register();

        $this->app->singleton(Apiato::class, Apiato::class);
        $this->overrideLaravelBaseProviders();
    }

    /**
     * Register Overided Base providers
     * @see \Illuminate\Foundation\Application::registerBaseServiceProviders
     */
    private function overrideLaravelBaseProviders(): void
    {
        App::register(EventServiceProvider::class); //The custom apiato eventserviceprovider
    }
}
