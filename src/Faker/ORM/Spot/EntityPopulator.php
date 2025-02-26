<?php

namespace Faker\ORM\Spot;

use Faker\Generator;
use Faker\Guesser\Name;
use Spot\Locator;
use Spot\Mapper;
use Spot\Relation\BelongsTo;

/**
 * Service class for populating a table through a Spot Entity class.
 */
class EntityPopulator
{
    /**
     * When fetching existing data - fetch only few first rows.
     */
    final public const RELATED_FETCH_COUNT = 10;

    /**
     * @var Mapper
     */
    protected $mapper;

    /**
     * @var Locator
     */
    protected $locator;

    /**
     * @var array
     */
    protected $columnFormatters = [];
    /**
     * @var array
     */
    protected $modifiers = [];

    /**
     * Class constructor.
     *
     * @param Mapper $mapper
     * @param Locator $locator
     * @param $useExistingData
     * @param bool $useExistingData
     */
    public function __construct(Mapper $mapper, Locator $locator, protected $useExistingData = false)
    {
        $this->mapper = $mapper;
        $this->locator = $locator;
    }

    /**
     * @return string
     */
    public function getMapper()
    {
        return $this->mapper;
    }

    /**
     * @return array
     */
    public function getColumnFormatters()
    {
        return $this->columnFormatters;
    }

    /**
     * @param $columnFormatters
     */
    public function setColumnFormatters($columnFormatters)
    {
        $this->columnFormatters = $columnFormatters;
    }

    /**
     * @param $columnFormatters
     */
    public function mergeColumnFormattersWith($columnFormatters)
    {
        $this->columnFormatters = array_merge($this->columnFormatters, $columnFormatters);
    }

    public function mergeModifiersWith(array $modifiers)
    {
        $this->modifiers = array_merge($this->modifiers, $modifiers);
    }

    /**
     * @return array
     */
    public function guessColumnFormatters(Generator $generator)
    {
        $formatters = [];
        $nameGuesser = new Name($generator);
        $columnTypeGuesser = new ColumnTypeGuesser($generator);
        $fields = $this->mapper->fields();
        foreach ($fields as $fieldName => $field) {
            if ($field['primary'] === true) {
                continue;
            }
            if ($formatter = $nameGuesser->guessFormat($fieldName)) {
                $formatters[$fieldName] = $formatter;
                continue;
            }
            if ($formatter = $columnTypeGuesser->guessFormat($field)) {
                $formatters[$fieldName] = $formatter;
                continue;
            }
        }
        $entityName = $this->mapper->entity();
        $entity = $this->mapper->build([]);
        $relations = $entityName::relations($this->mapper, $entity);
        foreach ($relations as $relation) {
            // We don't need any other relation here.
            if ($relation instanceof BelongsTo) {
                $fieldName = $relation->localKey();
                $entityName = $relation->entityName();
                $field = $fields[$fieldName];
                $required = $field['required'];

                $locator = $this->locator;

                $formatters[$fieldName] = function ($inserted) use ($required, $entityName, $locator) {
                    if (!empty($inserted[$entityName])) {
                        return $inserted[$entityName][mt_rand(0, (is_countable($inserted[$entityName]) ? count($inserted[$entityName]) : 0) - 1)]->get('id');
                    }

                    if ($required && $this->useExistingData) {
                        // We did not add anything like this, but it's required,
                        // So let's find something existing in DB.
                        $mapper = $locator->mapper($entityName);
                        $records = $mapper->all()->limit(self::RELATED_FETCH_COUNT)->toArray();
                        if (empty($records)) {
                            return null;
                        }

                        return $records[mt_rand(0, (is_countable($records) ? count($records) : 0) - 1)]['id'];
                    }

                    return null;
                };
            }
        }

        return $formatters;
    }

    /**
     * Insert one new record using the Entity class.
     *
     * @param $insertedEntities
     * @return string
     */
    public function execute($insertedEntities)
    {
        $obj = $this->mapper->build([]);

        $this->fillColumns($obj, $insertedEntities);
        $this->callMethods($obj, $insertedEntities);

        $this->mapper->insert($obj);


        return $obj;
    }

    /**
     * @param $obj
     * @param $insertedEntities
     */
    private function fillColumns($obj, $insertedEntities)
    {
        foreach ($this->columnFormatters as $field => $format) {
            if (null !== $format) {
                $value = is_callable($format) ? $format($insertedEntities, $obj) : $format;
                $obj->set($field, $value);
            }
        }
    }

    /**
     * @param $obj
     * @param $insertedEntities
     */
    private function callMethods($obj, $insertedEntities)
    {
        foreach ($this->getModifiers() as $modifier) {
            $modifier($obj, $insertedEntities);
        }
    }

    /**
     * @return array
     */
    public function getModifiers()
    {
        return $this->modifiers;
    }

    public function setModifiers(array $modifiers)
    {
        $this->modifiers = $modifiers;
    }
}
