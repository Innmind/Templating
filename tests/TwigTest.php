<?php
declare(strict_types = 1);

namespace Tests\Innmind\Templating;

use Innmind\Templating\{
    Twig,
    Engine,
    Name,
    Exception\FailedToRenderTemplate,
};
use Innmind\Url\Path;
use Innmind\Stream\Readable;
use Innmind\Immutable\Map;
use PHPUnit\Framework\TestCase;

class TwigTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            Engine::class,
            new Twig(Path::of('/tmp')),
        );
    }

    public function testRender()
    {
        $helper = new \stdClass;
        $helper->name = 'default';

        $render = new Twig(
            Path::of('fixtures'),
            Path::of('/tmp/twig'),
            Map::of(['helper', $helper]),
        );

        $stream = $render(new Name('template.html.twig'));

        $this->assertInstanceOf(Readable::class, $stream);
        $this->assertSame('Hello default', $stream->toString()->match(
            static fn($string) => \trim($string),
            static fn() => null,
        ));

        $stream = $render(
            new Name('template.html.twig'),
            Map::of(['name', 'world']),
        );

        $this->assertSame('Hello world', $stream->toString()->match(
            static fn($string) => \trim($string),
            static fn() => null,
        ));
    }

    public function testThrowWhenFailingToRenderTemplate()
    {
        $render = new Twig(Path::of('fixtures'));

        $this->expectException(FailedToRenderTemplate::class);
        $this->expectExceptionMessage('unknown.html.twig');

        $render(new Name('unknown.html.twig'));
    }
}
