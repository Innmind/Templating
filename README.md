# Templating

[![Build Status](https://github.com/innmind/templating/workflows/CI/badge.svg?branch=master)](https://github.com/innmind/templating/actions?query=workflow%3ACI)
[![codecov](https://codecov.io/gh/innmind/templating/branch/develop/graph/badge.svg)](https://codecov.io/gh/innmind/templating)
[![Type Coverage](https://shepherd.dev/github/innmind/templating/coverage.svg)](https://shepherd.dev/github/innmind/templating)

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
    Path::of('templates/dir'),
    Path::of('/tmp/cache'), // optional
    Map::of('string', 'object'), // optional, variables accesible everywhere in templates
);
$rendered = $render(new Name('template.html.twig')); // Instance of Innmind\Stream\Readable
```
