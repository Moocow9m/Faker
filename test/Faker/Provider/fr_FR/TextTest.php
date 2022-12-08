<?php

namespace Faker\Test\Provider\fr_FR;

use PHPUnit\Framework\TestCase;

final class TextTest extends TestCase
{
    private \ReflectionClass $textClass;

    function testItShouldAppendEndPunctToTheEndOfString()
    {
        $this->assertSame(
            'Que faisaient-elles maintenant? À.',
            $this->getMethod('appendEnd')->invokeArgs(null, ['Que faisaient-elles maintenant? À '])
        );

        $this->assertSame(
            'Que faisaient-elles maintenant? À.',
            $this->getMethod('appendEnd')->invokeArgs(null, ['Que faisaient-elles maintenant? À—   '])
        );

        $this->assertSame(
            'Que faisaient-elles maintenant? À.',
            $this->getMethod('appendEnd')->invokeArgs(null, ['Que faisaient-elles maintenant? À,'])
        );

        $this->assertSame(
            'Que faisaient-elles maintenant? À!.',
            $this->getMethod('appendEnd')->invokeArgs(null, ['Que faisaient-elles maintenant? À! '])
        );

        $this->assertSame(
            'Que faisaient-elles maintenant? À.',
            $this->getMethod('appendEnd')->invokeArgs(null, ['Que faisaient-elles maintenant? À: '])
        );

        $this->assertSame(
            'Que faisaient-elles maintenant? À.',
            $this->getMethod('appendEnd')->invokeArgs(null, ['Que faisaient-elles maintenant? À; '])
        );
    }

    protected function getMethod($name)
    {
        $method = $this->textClass->getMethod($name);

        $method->setAccessible(true);

        return $method;
    }

    protected function setUp()
    {
        $this->textClass = new \ReflectionClass(\Faker\Provider\fr_FR\Text::class);
    }
}
