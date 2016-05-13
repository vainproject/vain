<?php

namespace Vain\Console\Commands;

use Illuminate\Console\Command;
use Pingpong\Modules\Facades\Module;

class Develop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vain:develop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Will disable every module load from vendor dirs, this enables you to symlink or clone external modules into \'modules/\'.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->loadAnyModule();
    }

    /**
     * calls a given command with every module
     * at its first argument.
     *
     */
    private function loadAnyModule()
    {
        $this->getModules()->each(function ($module) {
            $this->loadStudioModule($module);
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

    /**
     * Loads a modules using studio
     *
     * @param $module
     */
    private function loadStudioModule($module)
    {
        $studio = base_path('vendor/bin/studio');

        $moduleName = $module->getLowerName();
        $moduleDir = "modules/$moduleName";
        $repositoryUrl = $this->resolveRepositoryUrl($moduleName);

        if (!is_dir($moduleDir)) {
            // we create a new module by cloning from git
            $this->info("Creating module \"$moduleName\" in \"$moduleDir\" via studio...");
            $this->info("Fetching from git at \"$repositoryUrl\"...");

            $command = [$studio, 'create', $moduleDir, '--git', $repositoryUrl];
        } else {
            // we just make sure that the project is taken care of via studio
            $this->info("Already found module \"$moduleName\" in \"$moduleDir\", just loading it via studio...");

            $command = [$studio, 'load', $moduleDir];
        }

        $this->sh($command);
    }

    /**
     * Tries to resolve a repository url
     * from the given module name
     *
     * @param $module
     * @return string
     */
    private function resolveRepositoryUrl($module)
    {
        // this is rather hacky and has to be done better in the future
        return "git@github.com:vainproject/vain-$module.git";
    }

    /**
     * Executes a command via shell
     *
     * @param $command
     */
    private function sh($command)
    {
        system(implode(' ', $command));
    }
}