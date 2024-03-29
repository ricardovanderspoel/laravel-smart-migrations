<?php

namespace RicardoVanDerSpoel\LaravelSmartMigrations\Services;

use OpenAI;

class OpenAIService
{
    protected $client;

    public function __construct()
    {
        $apiKey = env('OPENAI_API_KEY');
        $this->client = !empty($apiKey) ? OpenAI::client($apiKey) : null;
    }

    public function suggestImprovements(string $modelName, array $testResults): array
    {
        $suggestions = [];
        foreach ($testResults['details'] as $detail) {
            $context = "Based on the test failure details: {$detail['message']} suggest improvements.";
            $suggestion = $this->generateText($context);
            $suggestions[$detail['type']] = $suggestion;
        }

        return $suggestions;
    }

    public function enhanceFilesContent($modelName, $migrationFilePath)
    {
        $enhancements = config('smartmigrations.enhancements');
        foreach ($enhancements as $type => $config) {
            $contextFiles = $config['context_files'] ?? [];
            $context = [$config['context']];
            foreach ($contextFiles as $fileType) {
                $context[] = $this->getFileContent($modelName, $fileType, $migrationFilePath);
            }
            $enhancedContent = $this->generateText(implode("\n", $context));
            $this->saveEnhancedContent($modelName, $enhancedContent, $type);
        }
    }

    protected function generateText($context)
    {
        $model = config('smartmigrations.openai_model');
        $response = $this->client->chat()->create([
            'model' => $model,
            'messages' => [['role' => 'user', 'content' => $context]],
            'max_tokens' => 1024,
            'n' => 1,
            'stop' => null,
            'temperature' => 0.5,
        ]);

        $message = $response['choices'][0]['message']['content'] ?? '';
        return $this->cleanContent($message);
    }

    protected function saveEnhancedContent($modelName, $content, $type)
    {
        $filePath = $this->getFilePath($modelName, $type);
        if ($filePath) {
            file_put_contents($filePath, $content);
        }
    }

    protected function getFileContent($modelName, $type, $migrationFilePath)
    {
        if ($type === 'migration') {
            return "Migration structure:\n" . file_get_contents($migrationFilePath);
        }

        $filePath = $this->getFilePath($modelName, $type);
        return $filePath && file_exists($filePath) ? ucfirst($type) . " structure:\n" . file_get_contents($filePath) : '';
    }

    protected function getFilePath($modelName, $type)
    {
        return match ($type) {
            'model' => app_path("Models/{$modelName}.php"),
            'migration' => database_path("migrations/{$modelName}.php"),
            'factory' => database_path("factories/{$modelName}Factory.php"),
            'seeder' => database_path("seeders/{$modelName}Seeder.php"),
            'request' => app_path("Http/Requests/{$modelName}Request.php"),
            'resource' => app_path("Http/Resources/{$modelName}Resource.php"),
            'controller' => app_path("Http/Controllers/{$modelName}Controller.php"),
            'test' => base_path("tests/Feature/{$modelName}Test.php"),
            default => null,
        };
    }

    protected function cleanContent($content) {
        $content = str_replace("```php", "", $content);
        $content = str_replace("```", "", $content);
        return preg_replace('/^\s*\n/', '', $content);
    }
}
