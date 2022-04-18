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
use Innmind\Filesystem\File\Content;
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

        $content = $render(new Name('template.html.twig'));

        $this->assertInstanceOf(Content::class, $content);
        $this->assertSame('Hello default', \trim($content->toString()));

        $content = $render(
            new Name('template.html.twig'),
            Map::of(['name', 'world']),
        );

        $this->assertSame('Hello world', \trim($content->toString()));
    }

    public function testThrowWhenFailingToRenderTemplate()
    {
        $render = new Twig(Path::of('fixtures'));

        $this->expectException(FailedToRenderTemplate::class);
        $this->expectExceptionMessage('unknown.html.twig');

        $render(new Name('unknown.html.twig'));
    }
}
