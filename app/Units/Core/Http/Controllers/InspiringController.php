<?php namespace App\Units\Core\Http\Controllers;

use Empari\Laravel\Support\Http\Controllers\Controller;
use Illuminate\Foundation\Inspiring;

/**
 * Class InspiringController
 *
 * @resource Extras
 * @package App\Units\Core\Http\Controllers
 */
class InspiringController extends Controller
{
    /**
     * Get a message for your inpiration
     *
     * @return array
     */
    public function index()
    {
        return $this->prepareResponse([
            'inspire' => Inspiring::quote()
        ]);
    }
}