<?php

namespace Faker\ORM\Doctrine;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;

class ColumnTypeGuesser
{
    protected $generator;

    public function __construct(\Faker\Generator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @param ClassMetadata $class
     * @return \Closure|null
     */
    public function guessFormat($fieldName, ClassMetadata $class)
    {
        $generator = $this->generator;
        $type = $class->getTypeOfField($fieldName);
        switch ($type) {
            case 'boolean':
                return fn() => $generator->boolean;
            case 'decimal':
                $size = $class->fieldMappings[$fieldName]['precision'] ?? 2;

                return fn() => $generator->randomNumber($size + 2) / 100;
            case 'smallint':
                return fn() => mt_rand(0, 65535);
            case 'integer':
                return fn() => mt_rand(0, intval('2147483647'));
            case 'bigint':
                return fn() => mt_rand(0, intval('18446744073709551615'));
            case 'float':
                return fn() => mt_rand(0, intval('4294967295')) / mt_rand(1, intval('4294967295'));
            case 'string':
                $size = $class->fieldMappings[$fieldName]['length'] ?? 255;

                return fn() => $generator->text($size);
            case 'text':
                return fn() => $generator->text;
            case 'datetime':
            case 'date':
            case 'time':
                return fn() => $generator->datetime;
            case 'datetime_immutable':
            case 'date_immutable':
            case 'time_immutable':
                return fn() => \DateTimeImmutable::createFromMutable($generator->datetime);
            default:
                // no smart way to guess what the user expects here
                return null;
        }
    }
}
