<?php

namespace Faker\ORM\Spot;

use Faker\Generator;

class ColumnTypeGuesser
{
    protected $generator;


    /**
     * ColumnTypeGuesser constructor.
     */
    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @return \Closure|null
     */
    public function guessFormat(array $field)
    {
        $generator = $this->generator;
        $type = $field['type'];
        switch ($type) {
            case 'boolean':
                return fn() => $generator->boolean;
            case 'decimal':
                $size = $field['precision'] ?? 2;

                return fn() => $generator->randomNumber($size + 2) / 100;
            case 'smallint':
                return fn() => $generator->numberBetween(0, 65535);
            case 'integer':
                return fn() => $generator->numberBetween(0, intval('2147483647'));
            case 'bigint':
                return fn() => $generator->numberBetween(0, intval('18446744073709551615'));
            case 'float':
                return fn() => $generator->randomFloat(null, 0, intval('4294967295'));
            case 'string':
                $size = $field['length'] ?? 255;

                return fn() => $generator->text($size);
            case 'text':
                return fn() => $generator->text;
            case 'datetime':
            case 'date':
            case 'time':
                return fn() => $generator->datetime;
            default:
                // no smart way to guess what the user expects here
                return null;
        }
    }
}
