<?php

namespace Vain\Console\Commands;

use Illuminate\Console\Command;
use Pingpong\Modules\Facades\Module;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vain:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initially runs all necessary setup steps to get up and running with vain.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // migrate the db
        $this->callAnyModule('module:migrate');

        // run seeding
        $this->call('db:seed');

        $this->callAnyModule('module:seed');
    }

    /**
     * calls a given command with every module
     * at its first argument.
     *
     * @param $command
     */
    private function callAnyModule($command)
    {
        $this->getModules()->each(function ($module) use ($command) {
            $this->call($command, [$module->getName()]);
        });
    }

    /**
     * returns a collection of all installed modules
     * ordered by priority.
     *
     * @return Collection
     */
    private function getModules()
    {
        return collect(Module::getOrdered());
    }
}
