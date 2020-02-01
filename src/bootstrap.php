<?php
declare(strict_types = 1);

namespace Innmind\Templating;

use Innmind\Url\Path;
use Innmind\Immutable\Map;

/**
 * @param Map<string, object>|null  $helpers
 */
function bootstrap(
    Path $templates,
    Path $cache = null,
    Map $helpers = null
): Engine {
    return new Twig($templates, $cache, $helpers);
}
