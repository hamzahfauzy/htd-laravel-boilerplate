<?php

namespace App\Console\Commands\Module;

use App\Libraries\Module;
use Illuminate\Console\Command;

class Enable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:enable {moduleName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enable module';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $moduleName = $this->argument('moduleName');
        if(Module::enable($moduleName))
        {
            $this->info("Enable module $moduleName success");
        }
        else
        {
            $this->error("Enable module $moduleName fail");
        }
    }
}
