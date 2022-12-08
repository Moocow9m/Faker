<?php

namespace Faker\Test\Provider\at_AT;

use Faker\Generator;
use Faker\Provider\at_AT\Payment;
use PHPUnit\Framework\TestCase;

final class PaymentTest extends TestCase
{

    private \Faker\Generator $faker;

    public function testVatIsValid()
    {
        $vat = $this->faker->vat();
        $unspacedVat = $this->faker->vat(false);
        $this->assertRegExp('/^(AT U\d{8})$/', $vat);
        $this->assertRegExp('/^(ATU\d{8})$/', $unspacedVat);
    }

    protected function setUp(): void
    {
        $faker = new Generator();
        $faker->addProvider(new Payment($faker));
        $this->faker = $faker;
    }
}
