<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class MakeModuleCommand extends Command
{

    use \App\Console\Commands\Traits\Command;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'makeComponent {moduleName} {componentName} {--lang=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $moduleName = $this->argument('moduleName');
        $componentName = $this->argument('componentName');

        $this->titleMessage('იქმნება მოდულის კომპონენტები - ' . $componentName);

        $this->warnMessage('App\Modules\\' . ucfirst($moduleName) . '\Models\\' . $componentName);
        $this->warnMessage('App\Modules\\' . ucfirst($moduleName) . '\Controller\\Admin\\' . $componentName);
        $this->warnMessage('App\Modules\\' . ucfirst($moduleName) . '\Request\\Admin\\' . $componentName . '\CreateRequest');
        $this->warnMessage(Str::lower($componentName) . ' migration');

        $isConfirm = $this->confirm('დარწმუნებული ხართ, რომ გსურთ შექმნა?');

        if (!$isConfirm) return;

        try {

            // Models
            Artisan::call('makeModule:model Modules/' . ucfirst($moduleName)  . '/Models/'.$componentName);

            if ($this->option('lang') == 1){
                Artisan::call('makeModule:modelTranslation Modules/' . ucfirst($moduleName)  . '/Models/Translations/'.$componentName . 'Translation');
            }

            // Repository
            Artisan::call('makeModule:repository Modules/' . ucfirst($moduleName)  . '/Repositories/Eloquent/'.$componentName . 'Repository');
            Artisan::call('makeModule:repositoryInterface Modules/' . ucfirst($moduleName)  . '/Repositories/I'.$componentName . 'Repository');

            // Controller
            Artisan::call('makeModule:controller Modules/' . ucfirst($moduleName)  . '/Http/Controllers/Admin/'.$componentName . 'Controller');

            // Request
            Artisan::call('make:module:request ' . $moduleName . ' Admin/' . $componentName . '/CreateRequest');

            // Migration
            Artisan::call('make:module:migration ' . $moduleName . ' ' . $componentName . ' --create=' . Str::lower($componentName));

        } catch (\Exception $ex) {
            $this->errorMessage($ex->getMessage());
            return;
        }

        $this->infoMessage('კომპონენტი წარმატებით შექიმნა');

    }

}
