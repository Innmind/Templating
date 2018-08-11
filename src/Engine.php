<?php
declare(strict_types = 1);

namespace Innmind\Templating;

use Innmind\Stream\Readable;
use Innmind\Immutable\MapInterface;

interface Engine
{
    /**
     * @param MapInterface<string, mixed> $parameters
     */
    public function __invoke(Name $template, MapInterface $parameters = null): Readable;
}
