<?php

namespace Jigardarji\MakePcrudl;

use Illuminate\Support\ServiceProvider;

class MakePcrudlGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands(\Jigardarji\MakePcrudl\Console\Commands\MakeCrud::class);
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/stubs' => resource_path('crud-stubs')
        ]);
    }
}
