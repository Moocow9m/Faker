<?php

namespace Faker\ORM\Mandango;

class ColumnTypeGuesser
{
    protected $generator;

    /**
     * @param \Faker\Generator $generator
     */
    public function __construct(\Faker\Generator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @return \Closure|null
     */
    public function guessFormat($field)
    {
        $generator = $this->generator;
        switch ($field['type']) {
            case 'boolean':
                return fn() => $generator->boolean;
            case 'integer':
                return fn() => mt_rand(0, intval('4294967295'));
            case 'float':
                return fn() => mt_rand(0, intval('4294967295')) / mt_rand(1, intval('4294967295'));
            case 'string':
                return fn() => $generator->text(255);
            case 'date':
                return fn() => $generator->datetime;
            default:
                // no smart way to guess what the user expects here
                return null;
        }
    }
}
