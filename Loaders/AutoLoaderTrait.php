<?php

namespace Apiato\Core\Loaders;

use Apiato\Core\Foundation\Facades\Apiato;

trait AutoLoaderTrait
{
    // Using each component loader trait
    use ConfigsLoaderTrait;
    use LocalizationLoaderTrait;
    use MigrationsLoaderTrait;
    use ViewsLoaderTrait;
    use ProvidersLoaderTrait;
    use ConsolesLoaderTrait;
    use AliasesLoaderTrait;
    use HelpersLoaderTrait;

    /**
     * To be used from the `boot` function of the main service provider
     */
    public function runLoadersBoot(): void
    {
        // The config files should be loaded first from all the directories in their own loop
        $this->loadConfigsFromShip();
        $this->loadLocalsFromShip();
        $this->loadMigrationsFromShip();
        $this->loadViewsFromShip();
        $this->loadConsolesFromShip();
        $this->loadHelpersFromShip();

        // Iterate over all the containers folders and autoload most of the components
        foreach (Apiato::getContainerNames() as $containerName) {
            $this->loadConfigsFromContainers($containerName);
            $this->loadLocalsFromContainers($containerName);
            $this->loadOnlyMainProvidersFromContainers($containerName);
            $this->loadMigrationsFromContainers($containerName);
            $this->loadConsolesFromContainers($containerName);
            $this->loadViewsFromContainers($containerName);
            $this->loadHelpersFromContainers($containerName);
        }
    }
}
