<?php

namespace App\Console\Commands\Module;

use App\Libraries\Module;
use Illuminate\Console\Command;

class Disable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:disable {moduleName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disable module';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $moduleName = $this->argument('moduleName');
        if(Module::disable($moduleName))
        {
            $this->info("Disable module $moduleName success");
        }
        else
        {
            $this->error("Disable module $moduleName fail");
        }
    }
}
