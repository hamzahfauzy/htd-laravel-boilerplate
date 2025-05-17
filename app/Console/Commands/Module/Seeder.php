<?php

namespace App\Console\Commands\Module;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Seeder extends Command
{
    protected $signature = 'module:make-seeder {name} {module}';
    protected $description = 'Create a new seeder inside a custom module folder';

    public function handle()
    {
        $seederName = Str::studly($this->argument('name'));
        $moduleName = Str::studly($this->argument('module'));

        $path = base_path("app/Modules/{$moduleName}/Databases/seeders");

        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        $filePath = "{$path}/{$seederName}.php";

        if (File::exists($filePath)) {
            $this->error("Seeder {$seederName} already exists in module {$moduleName}.");
            return 1;
        }

        $namespace = "App\\Modules\\{$moduleName}\\Databases\\Seeders";

        $template = <<<PHP
<?php

namespace {$namespace};

use Illuminate\\Database\\Seeder;

class {$seederName} extends Seeder
{
    public function run(): void
    {
        //
    }
}
PHP;

        File::put($filePath, $template);

        $this->info("Seeder {$seederName} created successfully in module {$moduleName}.");
        return 0;
    }
}
