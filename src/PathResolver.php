<?php

declare(strict_types=1);

namespace Componenta\Stdlib;

use InvalidArgumentException;

final readonly class PathResolver implements PathResolverInterface
{
    public string $baseDir;

    /**
     * @throws InvalidArgumentException If the project root is not absolute.
     */
    public function __construct(string $root)
    {
        $root = self::normalize($root);

        if (!self::isAbsolute($root)) {
            throw new InvalidArgumentException(sprintf('Project root must be absolute, got: %s', $root));
        }

        $this->baseDir = rtrim($root, '/');
    }

    public function resolve(string $path): string
    {
        if ($path === '') {
            return $this->baseDir;
        }

        if (self::isAbsolute($path)) {
            return self::normalize($path);
        }

        return $this->baseDir . '/' . ltrim(self::normalize($path), '/');
    }

    private static function normalize(string $path): string
    {
        $path = str_replace('\\', '/', $path);

        $prefix = '';
        if (preg_match('#^([a-zA-Z]:/|/)#', $path, $matches) === 1) {
            $prefix = $matches[1];
            $path = substr($path, strlen($prefix));
        }

        $segments = [];

        foreach (explode('/', $path) as $segment) {
            if ($segment === '' || $segment === '.') {
                continue;
            }

            if ($segment === '..') {
                if ($segments !== [] && end($segments) !== '..') {
                    array_pop($segments);
                    continue;
                }

                if ($prefix !== '') {
                    continue;
                }

                $segments[] = '..';
                continue;
            }

            $segments[] = $segment;
        }

        return $prefix . implode('/', $segments);
    }

    private static function isAbsolute(string $path): bool
    {
        if ($path === '') {
            return false;
        }

        $path = str_replace('\\', '/', $path);

        return $path[0] === '/'
            || str_starts_with($path, '//')
            || preg_match('#^[a-zA-Z]:/#', $path) === 1;
    }
}
