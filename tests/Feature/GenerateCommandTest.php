<?php

use Hemil09\TypeGen\Tests\TestCase;

uses(TestCase::class);

it('generates a typescript file from a model with #[TypeScript]', function () {
    $outputPath = sys_get_temp_dir() . '/test.ts';
    
    config()->set('typegen.paths.models', __DIR__ . '/../Fixtures/Models');
    config()->set('typegen.output.path', $outputPath);

    $this->artisan('typescript:generate')->assertSuccessful();

    $contents = file_get_contents($outputPath);
    expect($contents)->toContain('export interface User');
    expect($contents)->toContain('is_admin: boolean');
    expect($contents)->toContain('name: string');
    
    @unlink($outputPath);
});

it('respects the --dry-run flag', function () {
    config()->set('typegen.paths.models', __DIR__ . '/../Fixtures/Models');
    
    $this->artisan('typescript:generate', ['--dry-run' => true])
        ->assertSuccessful()
        ->expectsOutputToContain('export interface User');
});

it('warns when no models are found', function () {
    config()->set('typegen.paths.models', __DIR__ . '/NonExistent');
    
    $this->artisan('typescript:generate')
        ->assertSuccessful()
        ->expectsOutputToContain('No classes found');
});

it('generates types for an enum and a request together', function () {
    config()->set('typegen.paths.enums', __DIR__ . '/../Fixtures/Enums');
    config()->set('typegen.paths.models', __DIR__ . '/../Fixtures/Models');
    
    $outputPath = sys_get_temp_dir() . '/v02.ts';
    config()->set('typegen.output.path', $outputPath);

    $this->artisan('typescript:generate')->assertSuccessful();

    $contents = file_get_contents($outputPath);

    expect($contents)
        ->toContain("export type PostStatus = 'draft' | 'published';")
        ->toContain('export interface User');
    
    @unlink($outputPath);
});
