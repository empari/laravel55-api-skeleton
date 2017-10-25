<?php namespace App\Units\Core\Http\Controllers;

use Empari\Laravel\Support\Http\Controllers\Controller;

/**
 * Class RoutingController
 *
 * @resource Extras
 * @package App\Units\Core\Http\Controllers
 */
class RoutingController extends Controller
{
    /**
     * Get all routes
     * @return json
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        if (!config('app.debug')) {
            throw new \Illuminate\Auth\Access\AuthorizationException();
        }

        return $this->prepareResponse(
            app('router')
                ->getRoutes() // return RouteColletion
                ->getRoutes() // return Routes in RouteColletion
        );
    }
}