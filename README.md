# Componenta Path Resolver

Project-root path resolver.

Use this package for resolving project files relative to a known base directory.

## Installation

```bash
composer require componenta/path-resolver
```

## Related Packages

| Package | Why it matters here |
|---|---|
| `componenta/app` | Creates `PathResolver` in entry points and passes it into bootstrapping. |
| `componenta/di` | Can inject `PathResolverInterface` into services that calculate project paths. |

## Path Resolver

```php
use Componenta\Stdlib\PathResolver;

$paths = new PathResolver('/var/www/app');

$paths->baseDir;                         // "/var/www/app"
$paths->resolve('config/container.php'); // "/var/www/app/config/container.php"
```

`PathResolverInterface` exposes an immutable `baseDir` property and a single `resolve()` method.

## Resolution Rules

- Relative paths are resolved against `baseDir`.
- Absolute paths are normalized and returned as absolute paths.
- The resolver does not check that a file exists.
- The resolver does not create directories.

This keeps the package usable in entry points, config files, cache builders, and libraries that only need deterministic path calculation.
