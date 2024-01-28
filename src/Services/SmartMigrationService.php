<?php

namespace RicardoVanDerSpoel\LaravelSmartMigrations\Services;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use RicardoVanDerSpoel\LaravelSmartMigrations\Services\OpenAIService;


class SmartMigrationService
{
    protected $filesystem;
    protected $openAIService;

    public function __construct(Filesystem $filesystem, OpenAIService $openAIService)
    {
        $this->filesystem = $filesystem;
        $this->openAIService = $openAIService;
    }

    public function getSmartMigrations()
    {
        $migrationFiles = $this->filesystem->files(database_path('migrations'));
        $smartMigrations = [];
        foreach ($migrationFiles as $migrationFile) {
            $contents = $this->filesystem->get($migrationFile);
            if (Str::contains($contents, 'protected $is_smart = true')) {
                $smartMigrations[] = [
                    'filename' => $migrationFile->getFilenameWithoutExtension(),
                    'content' => $contents,
                ];
            }
        }

        return $smartMigrations;
    }

    public function extractModelName($migrationContent)
    {
        preg_match("/Schema::create\('(.*?)'/", $migrationContent, $matches);
        return isset($matches[1]) ? Str::studly(Str::singular($matches[1])) : null;
    }

    public function extractFillableFields($migrationContent)
    {
        preg_match_all("/table->(.*?)\('(.*?)'/", $migrationContent, $matches);
        return $matches[2] ?? [];
    }

    public function getMigrationPath($migrationFilename)
    {
        return database_path("migrations/{$migrationFilename}.php");
    }

    public function generateFoundationalFiles($modelName, $fillableFields)
    {
        // Create Model
        Artisan::call('make:model', [
            'name' => $modelName
        ]);

        $modelPath = app_path("Models/{$modelName}.php");
        if (file_exists($modelPath)) {
            $modelContents = file_get_contents($modelPath);
            $fillableArray = "\n\tprotected \$fillable = ['" . implode("', '", $fillableFields) . "'];\n";
            $modelContents = str_replace("use HasFactory;\n", "use HasFactory;{$fillableArray}", $modelContents);
            file_put_contents($modelPath, $modelContents);
        }

        // Create a Resource
        Artisan::call('make:resource', [
            'name' => "{$modelName}Resource"
        ]);

        // Create a Request
        Artisan::call('make:request', [
            'name' => "{$modelName}Request"
        ]);

        // Create a Controller
        Artisan::call('make:controller', [
            'name' => "{$modelName}Controller",
            '--resource' => true,
            '--model' => $modelName,
        ]);

        // Create a Factory
        Artisan::call('make:factory', [
            'name' => "{$modelName}Factory",
            '--model' => "Models\\{$modelName}"
        ]);

        // Create a Seeder
        Artisan::call('make:seeder', [
            'name' => "{$modelName}Seeder"
        ]);
    }
}
