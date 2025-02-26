<?php

namespace Faker\Test\Provider\pt_PT;

use Faker\Generator;
use Faker\Provider\pt_PT\PhoneNumber;
use PHPUnit\Framework\TestCase;

final class PhoneNumberTest extends TestCase
{
    public function testPhoneNumberReturnsPhoneNumberWithOrWithoutPrefix()
    {
        $this->assertMatchesRegularExpression('/^(9[1,2,3,6][0-9]{7})|(2[0-9]{8})|(\+351 [2][0-9]{8})|(\+351 9[1,2,3,6][0-9]{7})/', $this->faker->phoneNumber());
    }

    public function testMobileNumberReturnsMobileNumberWithOrWithoutPrefix()
    {
        $this->assertMatchesRegularExpression('/^(9[1,2,3,6][0-9]{7})/', $this->faker->mobileNumber());
    }

    protected function setUp(): void
    {
        $faker = new Generator();
        $faker->addProvider(new PhoneNumber($faker));
        $this->faker = $faker;
    }
}
