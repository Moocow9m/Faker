<?php

namespace Faker\Provider\pl_PL;

use DateTime;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

final class PersonTest extends TestCase
{
    private Generator $faker;

    public function testPeselLenght()
    {
        $pesel = $this->faker->pesel();

        $this->assertEquals(11, strlen((string) $pesel));
    }

    public function testPeselDate()
    {
        $date = new DateTime('1990-01-01');
        $pesel = $this->faker->pesel($date);

        $this->assertEquals('90', substr((string) $pesel, 0, 2));
        $this->assertEquals('01', substr((string) $pesel, 2, 2));
        $this->assertEquals('01', substr((string) $pesel, 4, 2));
    }

    public function testPeselDateWithYearAfter2000()
    {
        $date = new DateTime('2001-01-01');
        $pesel = $this->faker->pesel($date);

        $this->assertEquals('01', substr((string) $pesel, 0, 2));
        $this->assertEquals('21', substr((string) $pesel, 2, 2));
        $this->assertEquals('01', substr((string) $pesel, 4, 2));
    }

    public function testPeselDateWithYearAfter2100()
    {
        $date = new DateTime('2101-01-01');
        $pesel = $this->faker->pesel($date);

        $this->assertEquals('01', substr((string) $pesel, 0, 2));
        $this->assertEquals('41', substr((string) $pesel, 2, 2));
        $this->assertEquals('01', substr((string) $pesel, 4, 2));
    }

    public function testPeselDateWithYearAfter2200()
    {
        $date = new DateTime('2201-01-01');
        $pesel = $this->faker->pesel($date);

        $this->assertEquals('01', substr((string) $pesel, 0, 2));
        $this->assertEquals('61', substr((string) $pesel, 2, 2));
        $this->assertEquals('01', substr((string) $pesel, 4, 2));
    }

    public function testPeselDateWithYearBefore1900()
    {
        $date = new DateTime('1801-01-01');
        $pesel = $this->faker->pesel($date);

        $this->assertEquals('01', substr((string) $pesel, 0, 2));
        $this->assertEquals('81', substr((string) $pesel, 2, 2));
        $this->assertEquals('01', substr((string) $pesel, 4, 2));
    }

    public function testPeselSex()
    {
        $male = $this->faker->pesel(null, 'M');
        $female = $this->faker->pesel(null, 'F');

        $this->assertEquals(1, $male[9] % 2);
        $this->assertEquals(0, $female[9] % 2);
    }

    public function testPeselCheckSum()
    {
        $pesel = $this->faker->pesel();
        $weights = [1, 3, 7, 9, 1, 3, 7, 9, 1, 3, 1];
        $sum = 0;

        foreach ($weights as $key => $weight) {
            $sum += $pesel[$key] * $weight;
        }

        $this->assertEquals(0, $sum % 10);
    }

    protected function setUp(): void
    {
        $faker = new Generator();
        $faker->addProvider(new Person($faker));
        $this->faker = $faker;
    }
}
