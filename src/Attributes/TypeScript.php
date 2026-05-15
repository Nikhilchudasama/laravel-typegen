<?php

namespace Hemil09\TypeGen\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class TypeScript
{
    public function __construct(
        public ?string $name = null,   // override generated name
        public bool $export = true,    // emit `export interface` vs `interface`
    ) {}
}
