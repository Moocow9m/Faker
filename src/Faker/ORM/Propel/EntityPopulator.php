<?php

namespace Faker\ORM\Propel;

use ColumnMap;
use Faker\Provider\Base;

/**
 * Service class for populating a table through a Propel ActiveRecord class.
 */
class EntityPopulator
{
    protected $columnFormatters = [];
    protected $modifiers = [];

    /**
     * Class constructor.
     *
     * @param string $class A Propel ActiveRecord classname
     */
    public function __construct(protected $class)
    {
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    public function mergeColumnFormattersWith($columnFormatters)
    {
        $this->columnFormatters = array_merge($this->columnFormatters, $columnFormatters);
    }

    /**
     * @return array
     */
    public function guessColumnFormatters(\Faker\Generator $generator)
    {
        $formatters = [];
        $class = $this->class;
        $peerClass = $class::PEER;
        $tableMap = $peerClass::getTableMap();
        $nameGuesser = new \Faker\Guesser\Name($generator);
        $columnTypeGuesser = new ColumnTypeGuesser($generator);
        foreach ($tableMap->getColumns() as $columnMap) {
            // skip behavior columns, handled by modifiers
            if ($this->isColumnBehavior($columnMap)) {
                continue;
            }
            if ($columnMap->isForeignKey()) {
                $relatedClass = $columnMap->getRelation()->getForeignTable()->getClassname();
                $formatters[$columnMap->getPhpName()] = fn($inserted) => isset($inserted[$relatedClass]) ? $inserted[$relatedClass][mt_rand(0, (is_countable($inserted[$relatedClass]) ? count($inserted[$relatedClass]) : 0) - 1)] : null;
                continue;
            }
            if ($columnMap->isPrimaryKey()) {
                continue;
            }
            if ($formatter = $nameGuesser->guessFormat($columnMap->getPhpName(), $columnMap->getSize())) {
                $formatters[$columnMap->getPhpName()] = $formatter;
                continue;
            }
            if ($formatter = $columnTypeGuesser->guessFormat($columnMap)) {
                $formatters[$columnMap->getPhpName()] = $formatter;
                continue;
            }
        }

        return $formatters;
    }

    /**
     * @return bool
     */
    protected function isColumnBehavior(ColumnMap $columnMap)
    {
        foreach ($columnMap->getTable()->getBehaviors() as $name => $params) {
            $columnName = Base::toLower($columnMap->getName());
            switch ($name) {
                case 'nested_set':
                    $columnNames = [$params['left_column'], $params['right_column'], $params['level_column']];
                    if (in_array($columnName, $columnNames)) {
                        return true;
                    }
                    break;
                case 'timestampable':
                    $columnNames = [$params['create_column'], $params['update_column']];
                    if (in_array($columnName, $columnNames)) {
                        return true;
                    }
                    break;
            }
        }

        return false;
    }

    public function mergeModifiersWith($modifiers)
    {
        $this->modifiers = array_merge($this->modifiers, $modifiers);
    }

    /**
     * @return array
     */
    public function guessModifiers(\Faker\Generator $generator)
    {
        $modifiers = [];
        $class = $this->class;
        $peerClass = $class::PEER;
        $tableMap = $peerClass::getTableMap();
        foreach ($tableMap->getBehaviors() as $name => $params) {
            switch ($name) {
                case 'nested_set':
                    $modifiers['nested_set'] = function ($obj, $inserted) use ($class, $generator) {
                        if (isset($inserted[$class])) {
                            $queryClass = $class . 'Query';
                            $parent = $queryClass::create()->findPk($generator->randomElement($inserted[$class]));
                            $obj->insertAsLastChildOf($parent);
                        } else {
                            $obj->makeRoot();
                        }
                    };
                    break;
                case 'sortable':
                    $modifiers['sortable'] = function ($obj, $inserted) use ($class) {
                        $maxRank = isset($inserted[$class]) ? count($inserted[$class]) : 0;
                        $obj->insertAtRank(mt_rand(1, $maxRank + 1));
                    };
                    break;
            }
        }

        return $modifiers;
    }

    /**
     * Insert one new record using the Entity class.
     */
    public function execute($con, $insertedEntities)
    {
        $obj = new $this->class();
        foreach ($this->getColumnFormatters() as $column => $format) {
            if (null !== $format) {
                $obj->setByName($column, is_callable($format) ? $format($insertedEntities, $obj) : $format);
            }
        }
        foreach ($this->getModifiers() as $modifier) {
            $modifier($obj, $insertedEntities);
        }
        $obj->save($con);

        return $obj->getPrimaryKey();
    }

    /**
     * @return array
     */
    public function getColumnFormatters()
    {
        return $this->columnFormatters;
    }

    public function setColumnFormatters($columnFormatters)
    {
        $this->columnFormatters = $columnFormatters;
    }

    /**
     * @return array
     */
    public function getModifiers()
    {
        return $this->modifiers;
    }

    public function setModifiers($modifiers)
    {
        $this->modifiers = $modifiers;
    }
}
