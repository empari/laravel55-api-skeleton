<?php namespace App\Units\Core\Http\Routes;

use Empari\Laravel\Support\Http\Routing\RouteFileApi;

/**
 * Class CoreRoutes
 * @package App\Units\Core\Http\Routes
 */
class CoreRoutes extends RouteFileApi
{
    /**
     * Define Routes
     */
    protected function routes()
    {
        $this->router
            ->prefix('extras')
            ->group(function() {
                $this->router->resource('/inspiring', 'InspiringController', ['only' => ['index']]);
                $this->router->resource('/routing', 'RoutingController', ['only' => ['index']]);
        });
    }
}