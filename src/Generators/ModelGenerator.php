<?php

namespace Hemil09\TypeGen\Generators;

use Hemil09\TypeGen\Attributes\TypeScript;
use Hemil09\TypeGen\Mappers\CastTypeMapper;
use Illuminate\Database\Eloquent\Model;
use ReflectionClass;

class ModelGenerator
{
    public function __construct(
        protected CastTypeMapper $mapper,
        protected array $config,
    ) {}

    public function generate(string $modelClass): string
    {
        /** @var Model $instance */
        $instance = new $modelClass;
        $reflection = new ReflectionClass($modelClass);

        $name = $this->resolveName($reflection);
        $fields = $this->collectFields($instance);

        $body = collect($fields)
            ->map(fn ($type, $field) => "  {$field}: {$type};")
            ->implode("\n");

        $style = $this->config['output']['style'] ?? 'interface';
        $keyword = $style === 'type' ? "export type {$name} =" : "export interface {$name}";
        $opener = $style === 'type' ? ' {' : ' {';

        return "{$keyword}{$opener}\n{$body}\n}";
    }

    protected function resolveName(ReflectionClass $reflection): string
    {
        $attr = $reflection->getAttributes(TypeScript::class)[0] ?? null;
        $override = $attr?->newInstance()->name;
        if ($override) {
            return $override;
        }

        $base = $reflection->getShortName();

        return ($this->config['naming']['model_prefix'] ?? '')
            .$base
            .($this->config['naming']['model_suffix'] ?? '');
    }

    /** @return array<string,string> */
    protected function collectFields(Model $instance): array
    {
        $fields = [];

        // primary key
        $fields[$instance->getKeyName()] = $instance->getKeyType() === 'int' ? 'number' : 'string';

        // casts
        foreach ($instance->getCasts() as $attr => $cast) {
            if (! $this->config['include_hidden'] && in_array($attr, $instance->getHidden(), true)) {
                continue;
            }
            $fields[$attr] = $this->mapper->toTypeScript($cast);
        }

        // fillable (columns not in casts → assume string)
        foreach ($instance->getFillable() as $attr) {
            if (isset($fields[$attr])) {
                continue;
            }
            if (! $this->config['include_hidden'] && in_array($attr, $instance->getHidden(), true)) {
                continue;
            }
            $fields[$attr] = 'string';
        }

        // timestamps
        if ($this->config['include_timestamps'] && $instance->usesTimestamps()) {
            $fields[$instance->getCreatedAtColumn() ?? 'created_at'] = 'string';
            $fields[$instance->getUpdatedAtColumn() ?? 'updated_at'] = 'string';
        }

        return $fields;
    }
}
