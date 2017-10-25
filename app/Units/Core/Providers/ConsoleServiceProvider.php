<?php namespace App\Units\Core\Providers;

use App\Units\Core\Console\Commands\Inspire;
use Illuminate\Support\ServiceProvider;

class ConsoleServiceProvider extends ServiceProvider
{
    protected $commands = [
        Inspire::class
    ];

    public function register(){
        $this->commands($this->commands);
    }
}