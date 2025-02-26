<?php

namespace Faker\Test\Provider\nl_BE;

use Faker\Generator;
use Faker\Provider\nl_BE\Person;
use PHPUnit\Framework\TestCase;

/**
 * @group Person
 */
final class PersonTest extends TestCase
{
    private Generator $faker;

    public function testRrnIsValid()
    {
        $rrn = $this->faker->rrn();

        $this->assertEquals(11, strlen((string) $rrn));

        $ctrlNumber = substr((string) $rrn, 9, 2);
        $calcCtrl = 97 - (substr((string) $rrn, 0, 9) % 97);
        $altcalcCtrl = 97 - ((2 . substr((string) $rrn, 0, 9)) % 97);
        $this->assertContainsEquals($ctrlNumber, [$calcCtrl, $altcalcCtrl]);

        $middle = substr((string) $rrn, 6, 3);
        $this->assertGreaterThan(1, $middle);
        $this->assertLessThan(997, $middle);
    }

    public function testRrnIsMale()
    {
        $rrn = $this->faker->rrn('male');
        $this->assertEquals(substr((string) $rrn, 6, 3) % 2, 1);
    }

    public function testRrnIsFemale()
    {
        $rrn = $this->faker->rrn('female');
        $this->assertEquals(substr((string) $rrn, 6, 3) % 2, 0);
    }

    protected function setUp(): void
    {
        $faker = new Generator();
        $faker->addProvider(new Person($faker));
        $this->faker = $faker;
    }
}
