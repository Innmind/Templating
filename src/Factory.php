<?php
declare(strict_types = 1);

namespace Innmind\Templating;

use Innmind\Url\Path;
use Innmind\Immutable\Map;

final class Factory
{
    /**
     * @param Map<string, object>|null  $helpers
     */
    public static function build(
        Path $templates,
        Path $cache = null,
        Map $helpers = null
    ): Engine {
        return new Twig($templates, $cache, $helpers);
    }
}
