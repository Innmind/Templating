<?php
declare(strict_types = 1);

namespace Tests\Innmind\Templating;

use Innmind\Templating\{
    Name,
    Exception\DomainException,
};
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    public function testInterface()
    {
        $name = new Name('templates/template.html.twig');

        $this->assertSame('twig', $name->extension());
        $this->assertSame('templates/template.html.twig', (string) $name);
    }

    public function testThrowWhenEmptyName()
    {
        $this->expectException(DomainException::class);

        new Name('');
    }
}
