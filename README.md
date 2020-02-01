# Templating

| `develop` |
|-----------|
| [![codecov](https://codecov.io/gh/Innmind/Templating/branch/develop/graph/badge.svg)](https://codecov.io/gh/Innmind/Templating) |
| [![Build Status](https://github.com/Innmind/Templating/workflows/CI/badge.svg)](https://github.com/Innmind/Templating/actions?query=workflow%3ACI) |

Library to wrap php template engines (currently only twig).

## Installation

```sh
composer require innmind/templating
```

## Usage

```php
use function Innmind\Templating\bootstrap;
use Innmind\Templating\Name;
use Innmind\Url\Path;

$render = bootstrap(
    new Path('templates/dir'),
    new Path('/tmp/cache'), // optional
    new Map('string', 'object') // optional, variables accesible everywhere in templates
);
$rendered = $render(new Name('template.html.twig')); // Instance of Innmind\Stream\Readable
```
