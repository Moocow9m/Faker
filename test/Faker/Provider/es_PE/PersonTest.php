<?php

namespace Faker\Test\Provider\es_PE;

use Faker\Generator;
use Faker\Provider\es_PE\Person;
use PHPUnit\Framework\TestCase;

final class PersonTest extends TestCase
{
    private \Faker\Generator $faker;

    public function testDNI()
    {
        $dni = $this->faker->dni;
        $this->assertRegExp('/\A[0-9]{8}\Z/', $dni);
    }

    protected function setUp()
    {
        $faker = new Generator();
        $faker->seed(1);
        $faker->addProvider(new Person($faker));
        $this->faker = $faker;
    }
}
