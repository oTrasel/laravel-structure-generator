<?php

namespace Trasel\StructureGenerator\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

class MakeService extends Command
{
    protected $signature = 'make:service {name}';
    protected $description = 'Create a new service class';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $name = $this->argument('name');
        $filesystem = new Filesystem();

        $servicePath = app_path('Http/Services');
        $filePath = $servicePath . '/' . $name . '.php';

        if (!$filesystem->isDirectory($servicePath)) {
            $filesystem->makeDirectory($servicePath, 0755, true);
        }

        if ($filesystem->exists($filePath)) {
            $this->error('Service already exists!');
            return 1;
        }

        $content = "<?php\n\nnamespace App\Http\Services;\n\nclass {$name}\n{\n    // Service logic here\n}\n";
        $filesystem->put($filePath, $content);

        $this->info("Service {$name} created successfully!");
        return 0;
    }
}
