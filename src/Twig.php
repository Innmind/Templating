<?php
declare(strict_types = 1);

namespace Innmind\Templating;

use Innmind\Templating\Exception\FailedToRenderTemplate;
use Innmind\Url\PathInterface;
use Innmind\Stream\Readable;
use Innmind\Filesystem\Stream\StringStream;
use Innmind\Immutable\{
    MapInterface,
    Map,
};
use Twig\{
    Environment,
    Loader\FilesystemLoader,
};

final class Twig implements Engine
{
    private Environment $twig;

    public function __construct(
        PathInterface $templates,
        PathInterface $cache = null,
        MapInterface $helpers = null
    ) {
        $helpers ??= new Map('string', 'object');

        if (
            (string) $helpers->keyType() !== 'string' ||
            (string) $helpers->valueType() !== 'object'
        ) {
            throw new \TypeError('Argument 3 must be of type MapInterface<string, object>');
        }

        $this->twig = new Environment(
            new FilesystemLoader((string) $templates),
            [
                'cache' => $cache ? (string) $cache : false,
                'auto_reload' => is_null($cache),
                'strict_variables' => true,
            ]
        );
        $helpers->foreach(function(string $name, $helper): void {
            $this->twig->addGlobal($name, $helper);
        });
    }

    /**
     * {@inheritdo}
     */
    public function __invoke(Name $template, MapInterface $parameters = null): Readable
    {
        $parameters ??= new Map('string', 'mixed');

        if (
            (string) $parameters->keyType() !== 'string' ||
            (string) $parameters->valueType() !== 'mixed'
        ) {
            throw new \TypeError('Argument 2 must be of type MapInterface<string, mixed>');
        }

        try {
            return new StringStream(
                $this->twig->render(
                    (string) $template,
                    $parameters->reduce(
                        [],
                        static function(array $parameters, string $key, $value): array {
                            $parameters[$key] = $value;

                            return $parameters;
                        }
                    )
                )
            );
        } catch (\Throwable $e) {
            throw new FailedToRenderTemplate((string) $template, 0, $e);
        }
    }
}
