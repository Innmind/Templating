<?php
declare(strict_types = 1);

namespace Tests\Innmind\Templating;

use Innmind\Templating\Factory;
use Innmind\Templating\Twig;
use Innmind\Url\Path;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
    public function testBuild()
    {
        $this->assertInstanceOf(
            Twig::class,
            Factory::build(Path::of('fixtures'))
        );
    }
}
