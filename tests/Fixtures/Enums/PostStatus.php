<?php

namespace Hemil09\TypeGen\Tests\Fixtures\Enums;

use Hemil09\TypeGen\Attributes\TypeScript;

#[TypeScript]
enum PostStatus: string
{
    case Draft = 'draft';
    case Published = 'published';
}
