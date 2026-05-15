<?php

namespace Hemil09\TypeGen\Commands;

use Illuminate\Console\Command;
use Hemil09\TypeGen\Generators\ModelGenerator;
use Hemil09\TypeGen\Mappers\CastTypeMapper;
use Hemil09\TypeGen\Scanners\ClassScanner;
use Hemil09\TypeGen\Writers\TypeScriptWriter;

class GenerateCommand extends Command
{
    protected $signature = 'typescript:generate
                            {--dry-run : Print output instead of writing}';

    protected $description = 'Generate TypeScript types from Laravel models, enums, and form requests.';

    public function handle(ClassScanner $scanner): int
    {
        $config = config('typegen');
        $mapper = new CastTypeMapper($config['cast_map'] ?? []);
        $writer = new TypeScriptWriter($config);
        $generator = new ModelGenerator($mapper, $config);

        $models = $scanner->scan(
            [$config['paths']['models']],
            $config['scan_mode'] ?? 'attribute',
        );

        if (empty($models)) {
            $this->warn('No models found. Did you add the #[TypeScript] attribute?');
            return self::SUCCESS;
        }

        $this->info("Generating types for " . count($models) . " models...");

        $blocks = [];
        foreach ($models as $model) {
            $this->line("  ✓ {$model}");
            $blocks[] = $generator->generate($model);
        }

        if ($this->option('dry-run')) {
            $this->line("\n" . implode("\n\n", $blocks));
            return self::SUCCESS;
        }

        $path = $writer->write($blocks);
        $this->info("\nWritten to: {$path}");
        return self::SUCCESS;
    }
}
