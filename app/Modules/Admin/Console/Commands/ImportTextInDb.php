<?php


namespace App\Modules\Admin\Console\Commands;


use App\Console\Commands\Traits\Command as TraitCommand;
use App\Modules\Admin\Helper\ProfileHelper;
use App\Modules\Admin\Helper\RoleHelper;
use App\Modules\Admin\Helper\TextHelper;
use App\Modules\Admin\Helper\UserHelper;
use App\Modules\Admin\Models\Statics\Text;
use App\Modules\Admin\Repositories\Contracts\ITextRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class ImportTextInDb extends Command
{

    use TraitCommand;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:text:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all translation texts in db and file.';

    /**
     * @var ITextRepository
     */
    protected $textRepository;

    /**
     * Create a new command instance.
     *
     * @param ITextRepository $textRepository
     */
    public function __construct(
        ITextRepository $textRepository
    )
    {
        parent::__construct();
        $this->textRepository = $textRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $this->titleMessage('Start import text in db and file');

        foreach(config('language_manager.locales') as $locale) {

            $this->titleMessage('Start locale ' . $locale);

            app()->setLocale($locale);

            $langTexts = array_merge(TextHelper::getLang(), RoleHelper::getLang(), ProfileHelper::getLang(),UserHelper::getLang());

            foreach($langTexts as $langText) {

                $textArray = explode('.', $langText);
                $group = $textArray[0];
                $key =  implode('.', Arr::except($textArray, [0]));

                if( (strpos($langText, 'admin.') !== false ) ) {

                    if (!$this->textRepository->where('group', $group)->where('key', $key)->where('locale', $locale)->exists() ) {

                        $this->infoMessage('Import --group=' . $group . ' key=' . $key . ' locale=' . $locale);

                        $translation = $this->textRepository->firstOrNew([
                            'locale' => $locale,
                            'group' => $group,
                            'key' => $key,
                        ]);
                        $translation->value = $langText;
                        $translation->status = Text::STATUS_SAVED;
                        $translation->save();
                    }
                }

                // Save in file.
                $this->textRepository->exportTranslations($group);

            }

            $this->titleMessage('End locale ' . $locale);

        }

        $this->titleMessage('End import text in db and file');

    }

}
