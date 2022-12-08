<?php

namespace Faker\Test\Provider\zh_TW;

use PHPUnit\Framework\TestCase;

final class TextTest extends TestCase
{
    private \ReflectionClass $textClass;

    function testItShouldExplodeTheStringToArray()
    {
        $this->assertSame(
            ['中', '文', '測', '試', '真', '有', '趣'],
            $this->getMethod('explode')->invokeArgs(null, ['中文測試真有趣'])
        );

        $this->assertSame(
            ['標', '點', '，', '符', '號', '！'],
            $this->getMethod('explode')->invokeArgs(null, ['標點，符號！'])
        );
    }

    protected function getMethod($name)
    {
        $method = $this->textClass->getMethod($name);

        $method->setAccessible(true);

        return $method;
    }

    function testItShouldReturnTheStringLength()
    {
        $this->assertContains(
            $this->getMethod('strlen')->invokeArgs(null, ['中文測試真有趣']),
            [7, 21]
        );
    }

    function testItShouldReturnTheCharacterIsValidStartOrNot()
    {
        $this->assertTrue($this->getMethod('validStart')->invokeArgs(null, ['中']));

        $this->assertTrue($this->getMethod('validStart')->invokeArgs(null, ['2']));

        $this->assertTrue($this->getMethod('validStart')->invokeArgs(null, ['Hello']));

        $this->assertFalse($this->getMethod('validStart')->invokeArgs(null, ['。']));

        $this->assertFalse($this->getMethod('validStart')->invokeArgs(null, ['！']));
    }

    function testItShouldAppendEndPunctToTheEndOfString()
    {
        $this->assertSame(
            '中文測試真有趣。',
            $this->getMethod('appendEnd')->invokeArgs(null, ['中文測試真有趣'])
        );

        $this->assertSame(
            '中文測試真有趣。',
            $this->getMethod('appendEnd')->invokeArgs(null, ['中文測試真有趣，'])
        );

        $this->assertSame(
            '中文測試真有趣！',
            $this->getMethod('appendEnd')->invokeArgs(null, ['中文測試真有趣！'])
        );
    }

    protected function setUp()
    {
        $this->textClass = new \ReflectionClass(\Faker\Provider\zh_TW\Text::class);
    }
}
