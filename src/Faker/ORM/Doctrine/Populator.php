<?php

namespace Faker\ORM\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Faker\Generator;

/**
 * Service class for populating a database using the Doctrine ORM or ODM.
 * A Populator can populate several tables using ActiveRecord classes.
 */
class Populator
{
    /** @var Generator */
    protected $generator;

    /** @var ObjectManager|null */
    protected $manager;

    /** @var array */
    protected $entities = [];

    /** @var array */
    protected $quantities = [];

    /** @var array */
    protected $generateId = [];

    /**
     * Populator constructor.
     * @param ObjectManager|null $manager
     * @param int $batchSize
     */
    public function __construct(Generator $generator, ObjectManager $manager = null, protected $batchSize = 1000)
    {
        $this->generator = $generator;
        $this->manager = $manager;
    }

    /**
     * Add an order for the generation of $number records for $entity.
     *
     * @param mixed $entity A Doctrine classname, or a \Faker\ORM\Doctrine\EntityPopulator instance
     * @param int $number The number of entities to populate
     */
    public function addEntity(mixed $entity, $number, $customColumnFormatters = [], $customModifiers = [], $generateId = false)
    {
        if (!$entity instanceof EntityPopulator) {
            if (null === $this->manager) {
                throw new \InvalidArgumentException("No entity manager passed to Doctrine Populator.");
            }
            $entity = new EntityPopulator($this->manager->getClassMetadata($entity));
        }
        $entity->setColumnFormatters($entity->guessColumnFormatters($this->generator));
        if ($customColumnFormatters) {
            $entity->mergeColumnFormattersWith($customColumnFormatters);
        }
        $entity->mergeModifiersWith($customModifiers);
        $this->generateId[$entity->getClass()] = $generateId;

        $class = $entity->getClass();
        $this->entities[$class] = $entity;
        $this->quantities[$class] = $number;
    }

    /**
     * Populate the database using all the Entity classes previously added.
     *
     * Please note that large amounts of data will result in more memory usage since the the Populator will return
     * all newly created primary keys after executing.
     *
     * @param null|EntityManager $entityManager A Doctrine connection object
     *
     * @return array A list of the inserted PKs
     */
    public function execute($entityManager = null)
    {
        if (null === $entityManager) {
            $entityManager = $this->manager;
        }
        if (null === $entityManager) {
            throw new \InvalidArgumentException("No entity manager passed to Doctrine Populator.");
        }

        $insertedEntities = [];
        foreach ($this->quantities as $class => $number) {
            $generateId = $this->generateId[$class];
            for ($i = 0; $i < $number; $i++) {
                $insertedEntities[$class][] = $this->entities[$class]->execute(
                    $entityManager,
                    $insertedEntities,
                    $generateId
                );
                if (count($insertedEntities) % $this->batchSize === 0) {
                    $entityManager->flush();
                }
            }
            $entityManager->flush();
        }

        return $insertedEntities;
    }
}
