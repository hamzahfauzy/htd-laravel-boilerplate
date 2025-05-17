<?php

namespace App\Console\Commands\Module;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Model extends Command
{
    protected $signature = 'module:make-model 
                            {module : Nama modul, misal Blog} 
                            {name : Nama model, misal Post}
                            {--m|migration : Buat juga migration}
                            {--c|controller : Buat juga controller}
                            {--r|resource : Gunakan resource controller (dengan --controller)}
                            {--f|factory : Buat juga factory}
                            {--s|seeder : Buat juga seeder}';

    protected $description = 'Generate model untuk module tertentu di dalam folder app/Modules/<Module>/Models';

    public function handle()
    {
        $module = Str::studly($this->argument('module'));
        $name = Str::studly($this->argument('name'));

        $modelPath = base_path("app/Modules/{$module}/Models");

        if (!File::exists($modelPath)) {
            File::makeDirectory($modelPath, 0755, true);
        }

        $namespace = "App\\Modules\\{$module}\\Models";
        $filename = "{$modelPath}/{$name}.php";

        if (File::exists($filename)) {
            $this->error("❌ Model $name sudah ada di module $module.");
            return;
        }

        $content = <<<PHP
<?php

namespace {$namespace};

use Illuminate\Database\Eloquent\Model;

class {$name} extends Model
{
    //
}
PHP;

        File::put($filename, $content);

        $this->info("✅ Model [$name] berhasil dibuat di module [$module].");

        // Opsional: Buat migration, controller, factory, seeder
        if ($this->option('migration')) {
            $table = Str::snake(Str::pluralStudly($name));
            $this->call('module:make-migration', [
                'module' => $module,
                'name' => "create_{$table}_table",
                '--create' => $table,
            ]);
        }

        if ($this->option('controller')) {
            $controllerName = "{$name}Controller";
            $controllerPath = "App\\Modules\\{$module}\\Controllers";
            $params = [
                'name' => "{$controllerPath}\\{$controllerName}",
            ];
            if ($this->option('resource')) {
                $params['--resource'] = true;
            }

            $this->call('make:controller', $params);
        }

        if ($this->option('factory')) {
            $this->call('make:factory', [
                'name' => "{$name}Factory",
                '--model' => "{$namespace}\\{$name}",
            ]);
        }

        if ($this->option('seeder')) {
            $this->call('make:seeder', [
                'name' => "{$name}Seeder",
            ]);
        }
    }
}
