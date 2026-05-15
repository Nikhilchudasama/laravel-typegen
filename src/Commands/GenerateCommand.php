<?php

namespace Hemil09\TypeGen\Commands;

use Illuminate\Console\Command;
use Hemil09\TypeGen\Generators\EnumGenerator;
use Hemil09\TypeGen\Generators\FormRequestGenerator;
use Hemil09\TypeGen\Generators\ModelGenerator;
use Hemil09\TypeGen\Mappers\CastTypeMapper;
use Hemil09\TypeGen\Mappers\RuleToTypeMapper;
use Hemil09\TypeGen\Mappers\RuleTree;
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

        $blocks = [];

        // 1. Enums
        $enumPath = $config['paths']['enums'] ?? null;
        if ($enumPath && is_dir($enumPath)) {
            $enums = $scanner->scan([$enumPath], $config['scan_mode'] ?? 'attribute', filter: 'enum');
            $enumGenerator = new EnumGenerator($config);

            foreach ($enums as $enum) {
                $this->line("  ✓ enum {$enum}");
                $blocks[] = $enumGenerator->generate($enum);
            }
        }

        // 2. Form Requests
        $requestPath = $config['paths']['form_requests'] ?? null;
        if ($requestPath && is_dir($requestPath)) {
            $requests = $scanner->scan([$requestPath], $config['scan_mode'] ?? 'attribute');
            $requestGenerator = new FormRequestGenerator(
                new RuleToTypeMapper,
                new RuleTree,
                $config,
            );

            foreach ($requests as $request) {
                $this->line("  ✓ request {$request}");
                $blocks[] = $requestGenerator->generate($request);
            }
        }

        // 3. Models
        $models = $scanner->scan(
            [$config['paths']['models']],
            $config['scan_mode'] ?? 'attribute',
        );

        if (!empty($models)) {
            $this->info("Generating types for " . count($models) . " models...");
            foreach ($models as $model) {
                $this->line("  ✓ model {$model}");
                $blocks[] = $generator->generate($model);
            }
        }

        if (empty($blocks)) {
            $this->warn('No classes found. Did you add the #[TypeScript] attribute?');
            return self::SUCCESS;
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
