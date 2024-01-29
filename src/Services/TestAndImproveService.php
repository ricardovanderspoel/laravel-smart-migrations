<?php

namespace RicardoVanDerSpoel\LaravelSmartMigrations\Services;

use Symfony\Component\Process\Process;

class TestAndImproveService
{
    private $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    public function runTestsAndImprove(string $modelName): void
    {
        $testResults = $this->runTests($modelName);

        if ($testResults['failed']) {
            $suggestions = $this->openAIService->suggestImprovements($modelName, $testResults);
            $this->applyImprovements($modelName, $suggestions);
            $this->runTestsAndImprove($modelName);
        } else {
            echo "All tests passed for {$modelName}.\n";
        }
    }

    private function runTests(string $modelName): array
    {
        $process = new Process([
            'vendor/bin/phpunit',
            '--filter',
            $modelName,
            '--configuration',
            'phpunit.xml',
            '--json'
        ], base_path());

        $process->run();

        return json_decode($process->getOutput(), true);
    }

    private function applyImprovements(string $modelName, array $suggestions): void
    {
        foreach ($suggestions as $fileType => $content) {
            $filePath = $this->openAIService->getFilePath($modelName, $fileType);
            if ($filePath) {
                file_put_contents($filePath, $content);
            }
        }
    }
}
