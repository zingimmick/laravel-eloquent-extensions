<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\MonorepoBuilder\ValueObject\Option;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    $parameters->set(
        Option::DATA_TO_APPEND,
        [
            'authors' => [
                [
                    'name' => 'zingimmick',
                    'email' => 'zingimmick@outlook.com',
                ],
            ],
            'require' => [
                'php' => '^7.2 || ^8.0',
            ],
            'require-dev' => [
                'symplify/monorepo-builder' => '^8.3 || ^9.2',
            ],
            'config' => [
                'sort-packages' => true,
                'preferred-install' => 'dist',
            ],
            'minimum-stability' => 'dev',
            'prefer-stable' => true,
        ]
    );
};
