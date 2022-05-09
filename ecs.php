<?php

declare(strict_types=1);

use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Zing\CodingStandard\Set\ECSSetList;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->sets([ECSSetList::PHP_72, ECSSetList::CUSTOM]);
    $parameters = $ecsConfig->parameters();
    $ecsConfig->parallel();
    $ecsConfig->skip([
        \PHP_CodeSniffer\Standards\PSR1\Sniffs\Classes\ClassDeclarationSniff::class => ['*/migrations/*'],
        // Will be removed in a future major version.
        \SlevomatCodingStandard\Sniffs\TypeHints\ReturnTypeHintSniff::class,
    ]);
    $parameters->set(
        Option::PATHS,
        [__DIR__ . '/packages', __DIR__ . '/ecs.php', __DIR__ . '/monorepo-builder.php', __DIR__ . '/rector.php']
    );
};
