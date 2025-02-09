<?php

namespace Faker\Provider\tr_TR;

use Faker\Generator;
use PHPUnit\Framework\TestCase;

final class PaymentTest extends TestCase
{
    private Generator $faker;

    public function testBankAccountNumber()
    {
        $accNo = $this->faker->bankAccountNumber;
        $this->assertEquals(substr($accNo, 0, 2), 'TR');
        $this->assertEquals(26, strlen($accNo));
    }

    protected function setUp(): void
    {
        $faker = new Generator();
        $faker->addProvider(new Payment($faker));
        $this->faker = $faker;
    }
}
