<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Php70\Rector\FuncCall\RandomFunctionRector;
use Rector\Php81\Rector\Array_\FirstClassCallableRector;
use Rector\Php81\Rector\ClassConst\FinalizePublicClassConstantRector;
use Rector\PHPUnit\Set\PHPUnitLevelSetList;
use Rector\Set\ValueObject\LevelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/test',
    ]);

    $rectorConfig->skip(
        [
            __DIR__ . '/vendor',
            __DIR__ . '/.idea',
            // Faker wants random to be deterministic, this Rector makes it non-deterministic by replacing it with secure random
            RandomFunctionRector::class,
            FinalizePublicClassConstantRector::class => [
                __DIR__ . '/src/Faker/Provider/Person.php',
            ],
            FirstClassCallableRector::class => [
                __DIR__ . '/test/Faker/GeneratorTest.php',
            ],
        ]
    );

    $rectorConfig->phpVersion(PhpVersion::PHP_81);

    $rectorConfig->parallel(240, 4);

    $rectorConfig->sets(
        [
            LevelSetList::UP_TO_PHP_82,
            PHPUnitLevelSetList::UP_TO_PHPUNIT_100
        ]
    );
};
