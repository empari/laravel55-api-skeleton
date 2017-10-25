<?php namespace App\Units\Core\Providers;

use App\Units\Core\Http\Routes\CoreRoutes;
use Empari\Laravel\Support\Http\Providers\RouteServiceProvider as ServiceProvider;

/**
 * Class RouteServiceProvider
 * @package CBup\Units\Providers
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Units\Core\Http\Controllers';

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->registerRouteClass(CoreRoutes::class);
    }
}
