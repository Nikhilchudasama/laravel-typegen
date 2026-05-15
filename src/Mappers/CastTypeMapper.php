<?php

namespace Hemil09\TypeGen\Mappers;

class CastTypeMapper
{
    /** @var array<string,string> */
    protected array $map;

    public function __construct(array $overrides = [])
    {
        $this->map = array_merge($this->defaults(), $overrides);
    }

    public function toTypeScript(string $cast): string
    {
        // strip parameter portion: "decimal:2" -> "decimal"
        $base = explode(':', $cast)[0];
        return $this->map[$base] ?? 'unknown';
    }

    /** @return array<string,string> */
    protected function defaults(): array
    {
        return [
            // primitives
            'int'              => 'number',
            'integer'          => 'number',
            'real'             => 'number',
            'float'            => 'number',
            'double'           => 'number',
            'decimal'          => 'number',
            'string'           => 'string',
            'bool'             => 'boolean',
            'boolean'          => 'boolean',
            'array'            => 'unknown[]',
            'json'             => 'Record<string, unknown>',
            'object'           => 'Record<string, unknown>',
            'collection'       => 'unknown[]',
            // dates → string (ISO) by default; teams can override
            'date'             => 'string',
            'datetime'         => 'string',
            'immutable_date'   => 'string',
            'immutable_datetime'=> 'string',
            'timestamp'        => 'string',
            // misc
            'encrypted'        => 'string',
            'hashed'           => 'string',
        ];
    }
}
