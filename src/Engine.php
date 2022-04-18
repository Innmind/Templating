<?php
declare(strict_types = 1);

namespace Innmind\Templating;

use Innmind\Filesystem\File\Content;
use Innmind\Immutable\Map;

interface Engine
{
    /**
     * @param Map<string, mixed> $parameters
     */
    public function __invoke(Name $template, Map $parameters = null): Content;
}
