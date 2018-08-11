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
            new Twig(new Path('/tmp'))
        );
    }

    public function testThrowWhenInvalidHelpersKey()
    {
        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage('Argument 3 must be of type MapInterface<string, object>');

        new Twig(
            new Path('/tmp'),
            null,
            new Map('int', 'object')
        );
    }

    public function testThrowWhenInvalidHelpersValue()
    {
        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage('Argument 3 must be of type MapInterface<string, object>');

        new Twig(
            new Path('/tmp'),
            null,
            new Map('string', 'mixed')
        );
    }

    public function testRender()
    {
        $helper = new \stdClass;
        $helper->name = 'default';

        $render = new Twig(
            new Path('fixtures'),
            new Path('/tmp/twig'),
            (new Map('string', 'object'))
                ->put('helper', $helper)
        );

        $stream = $render(new Name('template.html.twig'));

        $this->assertInstanceOf(Readable::class, $stream);
        $this->assertSame('Hello default', trim((string) $stream));

        $stream = $render(
            new Name('template.html.twig'),
            (new Map('string', 'mixed'))
                ->put('name', 'world')
        );

        $this->assertSame('Hello world', trim((string) $stream));
    }

    public function testThrowWhenInvalidParametersKey()
    {
        $render = new Twig(new Path('fixtures'));

        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage('Argument 2 must be of type MapInterface<string, mixed>');

        $render(new Name('template.html.twig'), new Map('int', 'mixed'));
    }

    public function testThrowWhenInvalidParametersValue()
    {
        $render = new Twig(new Path('fixtures'));

        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage('Argument 2 must be of type MapInterface<string, mixed>');

        $render(new Name('template.html.twig'), new Map('string', 'variable'));
    }

    public function testThrowWhenFailingToRenderTemplate()
    {
        $render = new Twig(new Path('fixtures'));

        $this->expectException(FailedToRenderTemplate::class);
        $this->expectExceptionMessage('unknown.html.twig');

        $render(new Name('unknown.html.twig'));
    }
}
