<?php

namespace Faker\Test\Provider\es_ES;

use Faker\Generator;
use Faker\Provider\es_ES\Person;
use PHPUnit\Framework\TestCase;

final class PersonTest extends TestCase
{
    public function testDNI()
    {
        $dni = $this->faker->dni;
        $this->assertTrue($this->isValidDNI($dni));
    }

    public function isValidDNI($string)
    {
        if (strlen((string) $string) != 9 ||
            preg_match('/^[XYZ]?([0-9]{7,8})([A-Z])$/i', (string) $string, $matches) !== 1
        ) {
            return false;
        }

        $map = 'TRWAGMYFPDXBNJZSQVHLCKE';

        [, $number, $letter] = $matches;

        return strtoupper($letter) === $map[((int)$number) % 23];
    }

    // validation taken from http://kiwwito.com/php-function-for-spanish-dni-nie-validation/

    public function testLicenceCode()
    {
        $validLicenceCodes = ['AM', 'A1', 'A2', 'A', 'B', 'B+E', 'C1', 'C1+E', 'C', 'C+E', 'D1', 'D1+E', 'D', 'D+E'];

        $this->assertContains($this->faker->licenceCode, $validLicenceCodes);
    }

    protected function setUp(): void
    {
        $faker = new Generator();
        $faker->seed(1);
        $faker->addProvider(new Person($faker));
        $this->faker = $faker;
    }
}
