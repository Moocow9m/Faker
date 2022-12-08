<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;
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
        ]
    );

    $rectorConfig->phpVersion(PhpVersion::PHP_74);

    $rectorConfig->parallel(240, 4);

    $rectorConfig->sets(
        [
            LevelSetList::UP_TO_PHP_56,
        ]
    );
};
