<?php
declare(strict_types = 1);

namespace Innmind\Templating;

use Innmind\Templating\Exception\FailedToRenderTemplate;
use Innmind\Url\Path;
use Innmind\Filesystem\File\Content;
use Innmind\Immutable\Map;
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
        Map $helpers = null,
    ) {
        /** @var Map<string, object> */
        $helpers ??= Map::of();

        $this->twig = new Environment(
            new FilesystemLoader($templates->toString()),
            [
                'cache' => $cache ? $cache->toString() : false,
                'auto_reload' => \is_null($cache),
                'strict_variables' => true,
            ],
        );
        $_ = $helpers->foreach(function(string $name, object $helper): void {
            $this->twig->addGlobal($name, $helper);
        });
    }

    public function __invoke(Name $template, Map $parameters = null): Content
    {
        $parameters ??= Map::of();

        try {
            return Content\Lines::ofContent(
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
