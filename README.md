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
