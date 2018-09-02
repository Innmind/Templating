<?php
declare(strict_types = 1);

namespace Tests\Innmind\Templating;

use function Innmind\Templating\bootstrap;
use Innmind\Templating\Twig;
use Innmind\Url\Path;
use PHPUnit\Framework\TestCase;

class BootstrapTest extends TestCase
{
    public function testBootstrap()
    {
        $this->assertInstanceOf(
            Twig::class,
            bootstrap(new Path('fixtures'))
        );
    }
}
