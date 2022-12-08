<?php

namespace Faker\ORM\CakePHP;

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
    public function guessFormat($column, $table)
    {
        $generator = $this->generator;
        $schema = $table->schema();

        switch ($schema->columnType($column)) {
            case 'boolean':
                return fn() => $generator->boolean;
            case 'integer':
                return fn() => mt_rand(0, intval('2147483647'));
            case 'biginteger':
                return fn() => mt_rand(0, intval('9223372036854775807'));
            case 'decimal':
            case 'float':
                return fn() => $generator->randomFloat();
            case 'uuid':
                return fn() => $generator->uuid();
            case 'string':
                if (method_exists($schema, 'getColumn')) {
                    $columnData = $schema->getColumn($column);
                } else {
                    $columnData = $schema->column($column);
                }
                $length = $columnData['length'];
                return fn() => $generator->text($length);
            case 'text':
                return fn() => $generator->text();
            case 'date':
            case 'datetime':
            case 'timestamp':
            case 'time':
                return fn() => $generator->datetime();

            case 'binary':
            default:
                return null;
        }
    }
}
