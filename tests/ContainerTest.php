<?php
declare(strict_types = 1);

namespace Tests\Innmind\Templating;

use Innmind\Templating\Twig;
use Innmind\Compose\ContainerBuilder\ContainerBuilder;
use Innmind\Url\Path;
use Innmind\Immutable\Map;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public function testLoad()
    {
        $container = (new ContainerBuilder)(
            new Path('container.yml'),
            (new Map('string', 'mixed'))
                ->put('templates', new Path('fixtures'))
        );

        $this->assertInstanceOf(Twig::class, $container->get('engine'));
    }
}
