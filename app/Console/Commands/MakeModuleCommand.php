<?php

namespace App\Console\Commands;

use App\Modules\Admin\Http\Controllers\BaseController;
use App\Modules\Admin\Models\BaseModel;
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

            $repositoryInterfaceClass = 'Modules/' . ucfirst($moduleName)  . '/Repositories/Contracts/I'.$componentName . 'Repository';
            $repositoryClass = 'Modules/' . ucfirst($moduleName)  . '/Repositories/Eloquent/'.$componentName . 'Repository';
            $modelClass = 'Modules/' . ucfirst($moduleName)  . '/Models/'.$componentName;
            $tableName = Str::plural(Str::lower($componentName));
            // Repository
            Artisan::call('makeModule:repositoryInterface ' . $repositoryInterfaceClass);
            Artisan::call('makeModule:repository Modules/' . ucfirst($moduleName)  . '/Repositories/Eloquent/'.$componentName . 'Repository 
            --interface=App-' . str_replace('/', "-", $repositoryInterfaceClass) .' --model=App-' . str_replace('/', "-", $modelClass));

            // Create Models.
            if ($this->option('lang') == 1){

                $translatableModel = 'Modules/' . ucfirst($moduleName)  . '/Models/Translations/'.$componentName . 'Translation';

                // Models
                Artisan::call('makeModule:model ' . $modelClass . ' 
                --translate_model=-App-' . str_replace('/', "-", $translatableModel)
                . ' --table=' . $tableName
                . ' --base_model=-' .  str_replace('\\', "-", BaseModel::class));
                Artisan::call('makeModule:modelTranslation ' . $translatableModel);

            } else {
                Artisan::call('makeModule:empty-model ' . $modelClass .
                    ' --base_model=-' .  str_replace('\\', "-", BaseModel::class) .
                    ' --table=' . $tableName
                );
            }

            $requestClass = 'Admin/' . $componentName . '/CreateRequest';

            // Controller
            Artisan::call('makeModule:controller Modules/' . ucfirst($moduleName)  . '/Http/Controllers/Admin/'.$componentName . 'Controller '
            . ' --key=' . Str::lower($componentName)
            . ' --repository=App-' .str_replace('/', "-", $repositoryClass)
            . ' --base_controller=-' . str_replace('\\', "-", BaseController::class)
            . ' --create_request=App-' . str_replace('/', "-", $requestClass)
            );

            // Request
            Artisan::call('make:module:request ' . $moduleName . ' ' . $requestClass);

            // Request
            Artisan::call('make:module:request ' . $moduleName . ' ' . $requestClass);

            //Helper
            Artisan::call('makeModule:helper   Modules/' . ucfirst($moduleName)  . '/Helper/'.$componentName . 'Helper '.
                ' --key=' .  Str::lower($componentName)
            );

            // Migration
            Artisan::call('make:module:migration ' . $moduleName . ' ' . $componentName . ' --create=' . $tableName);

        } catch (\Exception $ex) {
            $this->errorMessage($ex->getMessage());
            return;
        }

        $this->infoMessage('კომპონენტი წარმატებით შექიმნა');

    }

}