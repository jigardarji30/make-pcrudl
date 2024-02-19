<?php

namespace Jigardarji\LaraCrud;

use Illuminate\Support\ServiceProvider;

class LaraCrudGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands(\Jigardarji\LaraCrud\Console\Commands\MakeCrud::class);
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/stubs' => resource_path('crud-stubs')
        ]);
    }
}
