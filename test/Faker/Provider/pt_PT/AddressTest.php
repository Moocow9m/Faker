<?php

namespace Faker\Test\Provider\pt_PT;

use Faker\Generator;
use Faker\Provider\pt_PT\Address;
use Faker\Provider\pt_PT\Person;
use PHPUnit\Framework\TestCase;

final class AddressTest extends TestCase
{
    private Generator $faker;

    public function testPostCodeIsValid()
    {
        $main = '[1-9]{1}[0-9]{2}[0,1,4,5,9]{1}';
        $pattern = "/^($main)|($main-[0-9]{3})+$/";
        $postcode = $this->faker->postcode();
        $this->assertSame(preg_match($pattern, (string) $postcode), 1, $postcode);
    }

    public function testAddressIsSingleLine()
    {
        $this->faker->addProvider(new Person($this->faker));

        $address = $this->faker->address();
        $this->assertFalse(strstr((string) $address, "\n"));
    }

    protected function setUp(): void
    {
        $faker = new Generator();
        $faker->addProvider(new Address($faker));
        $this->faker = $faker;
    }
}
