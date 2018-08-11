# Templating

| `master` | `develop` |
|----------|-----------|
| [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Innmind/Templating/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Innmind/Templating/?branch=master) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Innmind/Templating/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/Innmind/Templating/?branch=develop) |
| [![Code Coverage](https://scrutinizer-ci.com/g/Innmind/Templating/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Innmind/Templating/?branch=master) | [![Code Coverage](https://scrutinizer-ci.com/g/Innmind/Templating/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/g/Innmind/Templating/?branch=develop) |
| [![Build Status](https://scrutinizer-ci.com/g/Innmind/Templating/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Innmind/Templating/build-status/master) | [![Build Status](https://scrutinizer-ci.com/g/Innmind/Templating/badges/build.png?b=develop)](https://scrutinizer-ci.com/g/Innmind/Templating/build-status/develop) |

Library to wrap php template engines (currently only twig).

## Installation

```sh
composer require innmind/templating
```

## Usage

```php
use Innmind\Compose\ContainerBuilder\ContainerBuilder;
use Innmind\Url\Path;
use Innmind\Immutable\Map;
use Innmind\Templating\Name;

$container = (new ContainerBuilder)(
    new Path('container.yml'),
    (new Map('string', 'mixed'))
        ->put('templates', new Path('templates/dir'))
        ->put('cache', new Path('/tmp/cache')) // optional
        ->put('helpers', new Map('string', 'object')) // optional, variables accesible everywhere in templates
);

$render = $container->get('engine');
$rendered = $render(new Name('template.html.twig')); // Instance of Innmind\Stream\Readable
```
