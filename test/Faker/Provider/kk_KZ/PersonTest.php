<?php

namespace Faker\Test\Provider\kk_KZ;

use Faker\Generator;
use Faker\Provider\DateTime;
use Faker\Provider\kk_KZ\Person;
use PHPUnit\Framework\TestCase;

final class PersonTest extends TestCase
{
    public function testIndividualIdentificationNumberIsValid()
    {
        $birthDate = DateTime::dateTimeBetween('-30 years', '-10 years');
        $individualIdentificationNumber = $this->faker->individualIdentificationNumber($birthDate);
        $controlDigit = Person::checkSum($individualIdentificationNumber);

        $this->assertSame($controlDigit, (int)substr((string) $individualIdentificationNumber, 11, 1));
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->faker = new Generator();

        $this->faker->addProvider(new Person($this->faker));
    }
}
