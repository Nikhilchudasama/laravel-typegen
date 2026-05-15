<?php

namespace Hemil09\TypeGen\Scanners;

use ReflectionClass;
use Symfony\Component\Finder\Finder;
use Hemil09\TypeGen\Attributes\TypeScript;

class ClassScanner
{
    /**
     * @param  array<string>  $paths
     * @return array<class-string>
     */
    public function scan(array $paths, string $mode = 'attribute'): array
    {
        $classes = [];

        foreach ($paths as $path) {
            if (! is_dir($path)) continue;

            foreach ((new Finder)->files()->in($path)->name('*.php') as $file) {
                $fqcn = $this->classFromFile($file->getRealPath());
                if (! $fqcn || ! class_exists($fqcn)) continue;

                if ($mode === 'all' || $this->hasAttribute($fqcn)) {
                    $classes[] = $fqcn;
                }
            }
        }

        return $classes;
    }

    private function hasAttribute(string $fqcn): bool
    {
        return (bool) (new ReflectionClass($fqcn))
            ->getAttributes(TypeScript::class);
    }

    private function classFromFile(string $path): ?string
    {
        $contents = file_get_contents($path);
        if (! preg_match('/namespace\s+([^;]+);/', $contents, $ns)) return null;
        if (! preg_match('/class\s+(\w+)/', $contents, $cls)) return null;
        return trim($ns[1]) . '\\' . $cls[1];
    }
}
