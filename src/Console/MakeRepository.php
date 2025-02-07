<?php

namespace Trasel\StructureGenerator\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeRepository extends Command
{
    protected $signature = 'make:repository {name}';
    protected $description = 'Create a new Repository class';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $name = $this->argument('name');
        $filesystem = new Filesystem();

        $servicePath = app_path('Http/Repositories');
        $filePath = $servicePath . '/' . $name . '.php';

        if (!$filesystem->isDirectory($servicePath)) {
            $filesystem->makeDirectory($servicePath, 0755, true);
        }

        if ($filesystem->exists($filePath)) {
            $this->error('Repository already exists!');
            return 1;
        }
        
        $content = "<?php\n\nnamespace App\Http\Repositories;\n\nclass {$name}\n{\n    // Repository logic here\n}\n";
        $filesystem->put($filePath, $content);

        $this->info("Repository {$name} created successfully!");
        return 0;
    }
}
