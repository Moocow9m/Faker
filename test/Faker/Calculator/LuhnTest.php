<?php

namespace Faker\Test\Calculator;

use Faker\Calculator\Luhn;
use PHPUnit\Framework\TestCase;

final class LuhnTest extends TestCase
{
    public function checkDigitProvider()
    {
        return [['7992739871', '3'], ['3852000002323', '7'], ['37144963539843', '1'], ['561059108101825', '0'], ['601100099013942', '4'], ['510510510510510', '0'], [7_992_739_871, '3'], [3_852_000_002_323, '7'], ['37144963539843', '1'], ['561059108101825', '0'], ['601100099013942', '4'], ['510510510510510', '0']];
    }

    /**
     * @dataProvider checkDigitProvider
     */
    public function testComputeCheckDigit($partialNumber, $checkDigit)
    {
        $this->assertIsString($checkDigit);
        $this->assertEquals($checkDigit, Luhn::computeCheckDigit($partialNumber));
    }

    public function validatorProvider()
    {
        return [['79927398710', false], ['79927398711', false], ['79927398712', false], ['79927398713', true], ['79927398714', false], ['79927398715', false], ['79927398716', false], ['79927398717', false], ['79927398718', false], ['79927398719', false], [79_927_398_713, true], [79_927_398_714, false]];
    }

    /**
     * @dataProvider validatorProvider
     */
    public function testIsValid($number, $isValid)
    {
        $this->assertEquals($isValid, Luhn::isValid($number));
    }

    public function testGenerateLuhnNumberWithInvalidPrefix()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument should be an integer.');
        Luhn::generateLuhnNumber('abc');
    }
}
