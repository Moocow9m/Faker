<?php

namespace Faker\ORM\Propel;

use ColumnMap;
use PropelColumnTypes;

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
     * @param ColumnMap $column
     * @return \Closure|null
     */
    public function guessFormat(ColumnMap $column)
    {
        $generator = $this->generator;
        if ($column->isTemporal()) {
            if ($column->isEpochTemporal()) {
                return fn() => $generator->dateTime;
            }

            return fn() => $generator->dateTimeAD;
        }
        $type = $column->getType();
        switch ($type) {
            case PropelColumnTypes::BOOLEAN:
            case PropelColumnTypes::BOOLEAN_EMU:
                return fn() => $generator->boolean;
            case PropelColumnTypes::NUMERIC:
            case PropelColumnTypes::DECIMAL:
                $size = $column->getSize();

                return fn() => $generator->randomNumber($size + 2) / 100;
            case PropelColumnTypes::TINYINT:
                return fn() => mt_rand(0, 127);
            case PropelColumnTypes::SMALLINT:
                return fn() => mt_rand(0, 32767);
            case PropelColumnTypes::INTEGER:
                return fn() => mt_rand(0, intval('2147483647'));
            case PropelColumnTypes::BIGINT:
                return fn() => mt_rand(0, intval('9223372036854775807'));
            case PropelColumnTypes::FLOAT:
                return fn() => mt_rand(0, intval('2147483647')) / mt_rand(1, intval('2147483647'));
            case PropelColumnTypes::DOUBLE:
            case PropelColumnTypes::REAL:
                return fn() => mt_rand(0, intval('9223372036854775807')) / mt_rand(1, intval('9223372036854775807'));
            case PropelColumnTypes::CHAR:
            case PropelColumnTypes::VARCHAR:
            case PropelColumnTypes::BINARY:
            case PropelColumnTypes::VARBINARY:
                $size = $column->getSize();

                return fn() => $generator->text($size);
            case PropelColumnTypes::LONGVARCHAR:
            case PropelColumnTypes::LONGVARBINARY:
            case PropelColumnTypes::CLOB:
            case PropelColumnTypes::CLOB_EMU:
            case PropelColumnTypes::BLOB:
                return fn() => $generator->text;
            case PropelColumnTypes::ENUM:
                $valueSet = $column->getValueSet();

                return fn() => $generator->randomElement($valueSet);
            case PropelColumnTypes::OBJECT:
            case PropelColumnTypes::PHP_ARRAY:
            default:
                // no smart way to guess what the user expects here
                return null;
        }
    }
}
