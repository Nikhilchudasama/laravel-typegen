<?php

namespace hemilrajput\TypeGen\Writers;

class TypeScriptSplitWriter
{
    public function __construct(protected array $config) {}

    /**
     * @param  array<string>  $blocks
     */
    public function write(array $blocks): string
    {
        $path = $this->config['output']['path'];
        $banner = $this->config['output']['banner'] ?? '';

        // Determine output directory: strip .ts extension from the output path and make it a folder
        $dir = dirname($path).'/'.pathinfo($path, PATHINFO_FILENAME);

        if (is_dir($dir)) {
            // Clean up old files in the directory to avoid leftover stale types
            foreach (glob("{$dir}/*.ts") as $file) {
                @unlink($file);
            }
        } else {
            @mkdir($dir, 0755, recursive: true);
        }

        // Map blocks to their defined type names
        $registeredTypes = [];
        $blockMap = [];

        foreach ($blocks as $block) {
            if (preg_match('/export\s+(?:interface|type|enum)\s+(\w+)/', $block, $match)) {
                $typeName = $match[1];
                $registeredTypes[] = $typeName;
                $blockMap[$typeName] = $block;
            }
        }

        // Write each type file with resolve imports
        foreach ($blockMap as $typeName => $blockContent) {
            $imports = [];
            foreach ($registeredTypes as $otherType) {
                if ($otherType === $typeName) {
                    continue;
                }

                // Match exact word boundaries
                if (preg_match('/\b'.preg_quote($otherType, '/').'\b/', $blockContent)) {
                    $imports[] = "import { {$otherType} } from './{$otherType}';";
                }
            }

            $fileContent = $banner;
            if (! empty($imports)) {
                $fileContent .= implode("\n", $imports)."\n\n";
            }
            $fileContent .= $blockContent."\n";

            file_put_contents("{$dir}/{$typeName}.ts", $fileContent);
        }

        // Write barrel index.ts
        $indexLines = [$banner];
        foreach (array_keys($blockMap) as $typeName) {
            $indexLines[] = "export * from './{$typeName}';";
        }
        $indexContent = implode("\n", $indexLines)."\n";
        file_put_contents("{$dir}/index.ts", $indexContent);

        return $dir;
    }
}
