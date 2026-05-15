<?php

namespace Hemil09\TypeGen\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Hemil09\TypeGen\TypeGenServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [TypeGenServiceProvider::class];
    }

    protected function defineEnvironment($app)
    {
        // Setup default config for tests
        $app['config']->set('typegen', include __DIR__ . '/../config/typegen.php');
    }
}
