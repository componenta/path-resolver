<?php

declare(strict_types=1);

namespace Componenta\Stdlib;

interface PathResolverInterface
{
    public string $baseDir { get; }

    public function resolve(string $path): string;
}
