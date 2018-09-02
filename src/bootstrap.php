<?php
declare(strict_types = 1);

namespace Innmind\Templating;

use Innmind\Url\PathInterface;
use Innmind\Immutable\MapInterface;

/**
 * @param MapInterface<string, object>|null  $helpers
 */
function bootstrap(
    PathInterface $templates,
    PathInterface $cache = null,
    MapInterface $helpers = null
): Engine {
    return new Twig(
        $templates,
        $cache,
        $helpers
    );
}
