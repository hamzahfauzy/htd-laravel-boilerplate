<?php

namespace App\Console\Commands\Module;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Migration extends Command
{
    protected $signature = 'module:make-migration 
                            {module : Nama modul, misal Blog} 
                            {name : Nama migration, misal create_posts_table}
                            {--create= : Nama tabel (opsional)}
                            {--table= : Nama tabel (opsional)}';

    protected $description = 'Generate migration file di dalam folder Modules/<ModuleName>/Database/Migrations';

    public function handle()
    {
        $module = Str::studly($this->argument('module'));
        $name = $this->argument('name');

        $migrationPath = base_path("app/Modules/{$module}/Databases/migrations");

        // Buat folder jika belum ada
        if (!File::exists($migrationPath)) {
            File::makeDirectory($migrationPath, 0755, true);
        }

        // Siapkan parameter tambahan
        $params = ['--path' => $this->relativeMigrationPath($migrationPath)];

        if ($this->option('create')) {
            $params['--create'] = $this->option('create');
        }

        if ($this->option('table')) {
            $params['--table'] = $this->option('table');
        }

        // Panggil migration artisan bawaan
        $this->call('make:migration', array_merge([
            'name' => $name,
        ], $params));

        $this->info("✅ Migration untuk module [$module] berhasil dibuat.");
    }

    protected function relativeMigrationPath($absolutePath)
    {
        return str_replace(base_path() . DIRECTORY_SEPARATOR, '', $absolutePath);
    }
}
