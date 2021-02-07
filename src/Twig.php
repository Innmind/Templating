<?php
declare(strict_types = 1);

namespace Innmind\Templating;

use Innmind\Templating\Exception\FailedToRenderTemplate;
use Innmind\Url\Path;
use Innmind\Stream\Readable;
use Innmind\Stream\Readable\Stream;
use Innmind\Immutable\Map;
use function Innmind\Immutable\assertMap;
use Twig\{
    Environment,
    Loader\FilesystemLoader,
};

final class Twig implements Engine
{
    private Environment $twig;

    /**
     * @param Map<string, object>|null $helpers
     */
    public function __construct(
        Path $templates,
        Path $cache = null,
        Map $helpers = null
    ) {
        /** @var Map<string, object> */
        $helpers ??= Map::of('string', 'object');

        assertMap('string', 'object', $helpers, 3);

        $this->twig = new Environment(
            new FilesystemLoader($templates->toString()),
            [
                'cache' => $cache ? $cache->toString() : false,
                'auto_reload' => is_null($cache),
                'strict_variables' => true,
            ],
        );
        $helpers->foreach(function(string $name, $helper): void {
            $this->twig->addGlobal($name, $helper);
        });
    }

    public function __invoke(Name $template, Map $parameters = null): Readable
    {
        $parameters ??= Map::of('string', 'mixed');

        assertMap('string', 'mixed', $parameters, 2);

        try {
            return Stream::ofContent(
                $this->twig->render(
                    $template->toString(),
                    $parameters->reduce(
                        [],
                        static function(array $parameters, string $key, $value): array {
                            /**
                             * @psalm-suppress MixedAssignment
                             * @psalm-suppress InvalidArrayOffset
                             */
                            $parameters[$key] = $value;

                            return $parameters;
                        },
                    ),
                ),
            );
        } catch (\Throwable $e) {
            throw new FailedToRenderTemplate($template->toString(), 0, $e);
        }
    }
}
