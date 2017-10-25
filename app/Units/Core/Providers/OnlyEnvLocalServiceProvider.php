<?php namespace App\Units\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class OnlyEnvLocalServiceProvider extends ServiceProvider
{
    /**
     * Services for register
     *
     * @var array
     */
    protected $services = [
        \Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class,
        \Mpociot\ApiDoc\ApiDocGeneratorServiceProvider::class,
    ];

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Only Environment local
        if ($this->app->environment() !== 'production') {
            foreach ($this->services as $serviceClass) {
                $this->registerClass($serviceClass);
            }
        }

        // Register Aliases
        $this->registerAliases();
    }

    /**
     * Register any application aliases
     * @return void
     */
    public function registerAliases() : void
    {
        // AliasLoader::getInstance()->alias('Module', \Nwidart\Modules\Facades\Module::class);
    }

    /**
     * Register a Class into Service Provider
     *
     * @param string|null $class
     */
    private function registerClass(string $class = null)
    {
        if(class_exists($class)){
            $this->app->register($class);
        }
    }
}