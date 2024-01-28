<?php

namespace RicardoVanDerSpoel\LaravelSmartMigrations\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use RicardoVanDerSpoel\LaravelSmartMigrations\Services\SmartMigrationService;
use RicardoVanDerSpoel\LaravelSmartMigrations\Services\OpenAIService;

class RunSmartMigrations extends Command
{
    protected $signature = 'migrate:smart';
    protected $description = 'Run smart migrations, generate components, and apply AI optimizations.';

    public function __construct(
        private SmartMigrationService $smartMigrationService,
        private OpenAIService $openAIService
    ) {
        parent::__construct();
    }

    public function handle(): void
    {
        if (!env('OPENAI_API_KEY')) {
            $this->error('The OPENAI_API_KEY environment variable is not set. Please add it to your .env file.');
            return;
        }

        $smartMigrations = $this->smartMigrationService->getSmartMigrations();
        if (empty($smartMigrations)) {
            $this->info('No smart migrations to run.');
            return;
        }

        foreach ($smartMigrations as $migration) {
            $migrationPath = $this->smartMigrationService->getMigrationPath($migration['filename']);
            $modelName = $this->smartMigrationService->extractModelName($migration['content']);
            if (!$modelName) {
                $this->error("Cannot extract model name from migration: {$migration['filename']}");
                continue;
            }

            $fillableFields = $this->smartMigrationService->extractFillableFields($migration['content']);
            $this->smartMigrationService->generateFoundationalFiles($modelName, $fillableFields);

            $this->openAIService->enhanceFilesContent($modelName, $migrationPath);

            $this->info("Completed smart migration processing for: {$modelName}");
        }
    }
}
