<?php

namespace App\Console\Commands\Module;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class Asset extends Command
{
    protected $signature = 'module:link-assets {module}';
    protected $description = 'Symlink folder Assets from module to public path';

    public function handle()
    {
        $module = ucfirst($this->argument('module'));

        $source = base_path("app/Modules/{$module}/Assets");
        $target = public_path("modules/" . strtolower($module));

        if (!File::exists($source)) {
            $this->error("❌ Assets not found: {$source}");
            return 1;
        }

        if (File::exists($target)) {
            $this->warn("⚠️ Link already exists: {$target}");
            return 0;
        }

        File::ensureDirectoryExists(dirname($target));
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $source = '"' . str_replace('/', '\\', $source) . '"';
            $target = '"' . str_replace('/', '\\', $target) . '"';
            $cmd = 'mklink /J '.$target.' '.$source;
            exec($cmd);
        } else {
            // gunakan symlink() seperti biasa di Linux/macOS
            symlink($source, $target);
        }

        $this->info("✅ Symlink created: {$target} → {$source}");
        return 0;
    }
}
