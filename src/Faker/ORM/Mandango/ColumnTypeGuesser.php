<?php

namespace Faker\ORM\Mandango;

class ColumnTypeGuesser
{
    protected $generator;

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
        return match ($field['type']) {
            'boolean' => fn() => $generator->boolean,
            'integer' => fn() => mt_rand(0, intval('4294967295')),
            'float' => fn() => mt_rand(0, intval('4294967295')) / mt_rand(1, intval('4294967295')),
            'string' => fn() => $generator->text(255),
            'date' => fn() => $generator->datetime,
            default => null,
        };
    }
}
