<?php

declare(strict_types=1);

namespace Componenta\Stdlib\Tests;

use Componenta\Stdlib\PathResolver;

it('resolves relative paths against an immutable base directory', function (): void {
    $resolver = new PathResolver('/var/www/app');

    expect($resolver->baseDir)->toBe('/var/www/app')
        ->and($resolver->resolve('config/../config/container.php'))->toBe('/var/www/app/config/container.php')
        ->and($resolver->resolve('/tmp/cache'))->toBe('/tmp/cache');
});

it('normalizes windows paths', function (): void {
    $resolver = new PathResolver('C:\\www\\app');

    expect($resolver->baseDir)->toBe('C:/www/app')
        ->and($resolver->resolve('var\\cache'))->toBe('C:/www/app/var/cache');
});
