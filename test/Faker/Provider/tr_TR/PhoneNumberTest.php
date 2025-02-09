<?php

namespace Faker\Test\Provider\tr_TR;

use Faker\Generator;
use Faker\Provider\tr_TR\PhoneNumber;
use PHPUnit\Framework\TestCase;

final class PhoneNumberTest extends TestCase
{
    private Generator $faker;

    public function testPhoneNumber()
    {
        for ($i = 0; $i < 100; $i++) {
            $number = $this->faker->phoneNumber;
            $baseNumber = preg_replace('/ *x.*$/', '', $number); // Remove possible extension
            $digits = array_values(array_filter(str_split($baseNumber), 'ctype_digit'));

            $this->assertGreaterThan(10, count($digits));
        }
    }

    protected function setUp(): void
    {
        $faker = new Generator();
        $faker->addProvider(new PhoneNumber($faker));
        $this->faker = $faker;
    }
}
