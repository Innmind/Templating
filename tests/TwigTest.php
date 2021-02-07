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
            new Twig(Path::of('/tmp'))
        );
    }

    public function testThrowWhenInvalidHelpersKey()
    {
        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage('Argument 3 must be of type Map<string, object>');

        new Twig(
            Path::of('/tmp'),
            null,
            Map::of('int', 'object')
        );
    }

    public function testThrowWhenInvalidHelpersValue()
    {
        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage('Argument 3 must be of type Map<string, object>');

        new Twig(
            Path::of('/tmp'),
            null,
            Map::of('string', 'mixed')
        );
    }

    public function testRender()
    {
        $helper = new \stdClass;
        $helper->name = 'default';

        $render = new Twig(
            Path::of('fixtures'),
            Path::of('/tmp/twig'),
            Map::of('string', 'object')
                ('helper', $helper)
        );

        $stream = $render(new Name('template.html.twig'));

        $this->assertInstanceOf(Readable::class, $stream);
        $this->assertSame('Hello default', \trim($stream->toString()));

        $stream = $render(
            new Name('template.html.twig'),
            Map::of('string', 'mixed')
                ('name', 'world')
        );

        $this->assertSame('Hello world', \trim($stream->toString()));
    }

    public function testThrowWhenInvalidParametersKey()
    {
        $render = new Twig(Path::of('fixtures'));

        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage('Argument 2 must be of type Map<string, mixed>');

        $render(new Name('template.html.twig'), Map::of('int', 'mixed'));
    }

    public function testThrowWhenInvalidParametersValue()
    {
        $render = new Twig(Path::of('fixtures'));

        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage('Argument 2 must be of type Map<string, mixed>');

        $render(new Name('template.html.twig'), Map::of('string', 'variable'));
    }

    public function testThrowWhenFailingToRenderTemplate()
    {
        $render = new Twig(Path::of('fixtures'));

        $this->expectException(FailedToRenderTemplate::class);
        $this->expectExceptionMessage('unknown.html.twig');

        $render(new Name('unknown.html.twig'));
    }
}
