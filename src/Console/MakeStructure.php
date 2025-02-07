<?php

namespace Trasel\StructureGenerator\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeStructure extends Command
{
    protected $signature = 'make:structure {name}';
    protected $description = 'Creates the Service, Controller and Repository for the given structure';

    public function handle()
    {
        $name = $this->argument('name');

        $controllerPath = app_path("Http/Controllers/{$name}Controller.php");
        $servicePath = app_path("Http/Services/{$name}Service.php");
        $repositoryPath = app_path("Http/Repositories/{$name}Repository.php");

        $this->createDirectoryIfNotExists(app_path("Http/Controllers"));
        $this->createDirectoryIfNotExists(app_path("Http/Services"));
        $this->createDirectoryIfNotExists(app_path("Http/Repositories"));

        if (File::exists($controllerPath) || File::exists($servicePath) || File::exists($repositoryPath)) {
            $this->error("One or more files already exist.");
            return;
        }

        $controllerStub = "<?php

namespace App\Http\Controllers;

use App\Http\Services\\{$name}Service;

class {$name}Controller extends Controller
{
    protected \${$name}Service;

    public function __construct({$name}Service \${$name}Service)
    {
        \$this->{$name}Service = \${$name}Service;
    }

    public function index()
    {
        return \$this->{$name}Service->getAll();
    }
}
";
        File::put($controllerPath, $controllerStub);

        $serviceStub = "<?php

namespace App\Http\Services;

use App\Http\Repositories\\{$name}Repository;

class {$name}Service
{
    protected \${$name}Repository;

    public function __construct({$name}Repository \${$name}Repository)
    {
        \$this->{$name}Repository = \${$name}Repository;
    }

    public function getAll()
    {
        return \$this->{$name}Repository->all();
    }
}
";
        File::put($servicePath, $serviceStub);

        $repositoryStub = "<?php

namespace App\Http\Repositories;

class {$name}Repository
{
    public function all()
    {

    }
}
";
        File::put($repositoryPath, $repositoryStub);

        $this->info("Structure created successfully: {$name}Controller, {$name}Service, {$name}Repository.");
    }

    private function createDirectoryIfNotExists($path)
    {
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
    }
}
