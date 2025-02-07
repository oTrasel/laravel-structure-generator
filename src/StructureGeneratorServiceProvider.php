<?php

namespace Trasel\StructureGenerator;

use Illuminate\Support\ServiceProvider;
use Trasel\StructureGenerator\Console\MakeService;
use Trasel\StructureGenerator\Console\MakeRepository;
use Trasel\StructureGenerator\Console\MakeStructure;

class StructureGeneratorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            MakeService::class,
            MakeRepository::class,
            MakeStructure::class,
        ]);
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeService::class,
                MakeRepository::class,
                MakeStructure::class,
            ]);
        }
    }
}

