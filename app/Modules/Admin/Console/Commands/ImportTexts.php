<?php

namespace App\Console\Commands;

use App\Modules\Admin\Repositories\Contracts\ITextRepository;
use Illuminate\Console\Command;

/**
 * @property ITextRepository textRepository
 */
class ImportTexts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:text';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all translation texts';

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

        // Import all translations
        $this->textRepository->importTranslations();

    }

}
