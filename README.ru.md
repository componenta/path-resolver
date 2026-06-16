# Componenta Path Resolver

Объект значения для путей в точечной нотации и резолвер файлов относительно корня проекта.

Используйте пакет для config paths вроде `database.connections.mysql` и для резолвинга проектных файлов относительно известной base directory.

## Установка

```bash
composer require componenta/path-resolver
```

## Связанные пакеты

| Пакет | Зачем нужен здесь |
|---|---|
| `componenta/app` | Создаёт `PathResolver` в точке входа и передаёт его дальше для резолвинга файлов проекта. |
| `componenta/di` | Может внедрять `PathResolverInterface` в сервисы, которым нужен расчёт путей. |

## Path Resolver

```php
use Componenta\Stdlib\PathResolver;

$paths = new PathResolver('/var/www/app');

$paths->baseDir;                         // "/var/www/app"
$paths->resolve('config/container.php'); // "/var/www/app/config/container.php"
```

`PathResolverInterface` раскрывает immutable property `baseDir` и единственный метод `resolve()`.

## Правила Резолвинга

- Relative paths резолвятся относительно `baseDir`.
- Absolute paths нормализуются и возвращаются как absolute paths.
- Resolver не проверяет существование файла.
- Resolver не создает директории.

Так пакет остается пригодным для entry points, config files, cache builders и библиотек, которым нужен только deterministic path calculation.
