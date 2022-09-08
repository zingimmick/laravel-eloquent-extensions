<?php

declare(strict_types=1);

use NunoMaduro\Larastan\ApplicationResolver;
use Rector\Core\Util\Reflection\PrivatesAccessor;

$resolver = new ApplicationResolver();
$app = $resolver->createApplication();
$vendorDir = getcwd() . DIRECTORY_SEPARATOR . 'vendor';
$composerConfigPath = dirname($vendorDir) . DIRECTORY_SEPARATOR . 'composer.json';
$privatesAccessor = new PrivatesAccessor();
if (file_exists($composerConfigPath)) {
    $contents = (string) file_get_contents($composerConfigPath);
    ApplicationResolver::$composer = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);
    $namespace = (string) key(ApplicationResolver::$composer['autoload']['psr-4']);
    $projectClasses = $privatesAccessor->callPrivateMethod($resolver, 'getProjectClasses', [$namespace, $vendorDir]);
    $serviceProviders = array_values(array_filter(
        $projectClasses,
        static function ($class) use ($namespace, $resolver, $privatesAccessor): bool {
            if (strpos($class, $namespace) !== 0) {
                return false;
            }

            return $privatesAccessor->callPrivateMethod($resolver, 'isServiceProvider', [$class]);
        }
    ));

    foreach ($serviceProviders as $serviceProvider) {
        $app->register($serviceProvider);
    }
}

return $app;
