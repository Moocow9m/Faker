<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Php70\Rector\FuncCall\RandomFunctionRector;
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
        ]
    );

    $rectorConfig->phpVersion(PhpVersion::PHP_81);

    //$rectorConfig->parallel(240, 4);
    $rectorConfig->disableParallel(); // parallel causes freezing, may solve later

    $rectorConfig->sets(
        [
            LevelSetList::UP_TO_PHP_74,
            PHPUnitLevelSetList::UP_TO_PHPUNIT_90
        ]
    );
};
