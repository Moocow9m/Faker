<?php

namespace Faker\Test\Provider\el_GR;

use PHPUnit\Framework\TestCase;

final class TextTest extends TestCase
{
    private \ReflectionClass $textClass;

    function testItShouldAppendEndPunctToTheEndOfString()
    {
        $this->assertSame(
            'Και δεν άκουσες το κλοπακλόπ, κλοπακλόπ, κλοπακλόπ.',
            $this->getMethod('appendEnd')->invokeArgs(null, ['Και δεν άκουσες το κλοπακλόπ, κλοπακλόπ, κλοπακλόπ '])
        );

        $this->assertSame(
            'Και δεν άκουσες το κλοπακλόπ, κλοπακλόπ, κλοπακλόπ.',
            $this->getMethod('appendEnd')->invokeArgs(null, ['Και δεν άκουσες το κλοπακλόπ, κλοπακλόπ, κλοπακλόπ—'])
        );

        $this->assertSame(
            'Και δεν άκουσες το κλοπακλόπ, κλοπακλόπ, κλοπακλόπ.',
            $this->getMethod('appendEnd')->invokeArgs(null, ['Και δεν άκουσες το κλοπακλόπ, κλοπακλόπ, κλοπακλόπ,'])
        );

        $this->assertSame(
            'Και δεν άκουσες το κλοπακλόπ, κλοπακλόπ, κλοπακλόπ!.',
            $this->getMethod('appendEnd')->invokeArgs(null, ['Και δεν άκουσες το κλοπακλόπ, κλοπακλόπ, κλοπακλόπ! '])
        );

        $this->assertSame(
            'Και δεν άκουσες το κλοπακλόπ, κλοπακλόπ, κλοπακλόπ.',
            $this->getMethod('appendEnd')->invokeArgs(null, ['Και δεν άκουσες το κλοπακλόπ, κλοπακλόπ, κλοπακλόπ; '])
        );

        $this->assertSame(
            'Και δεν άκουσες το κλοπακλόπ, κλοπακλόπ, κλοπακλόπ.',
            $this->getMethod('appendEnd')->invokeArgs(null, ['Και δεν άκουσες το κλοπακλόπ, κλοπακλόπ, κλοπακλόπ: '])
        );
    }

    protected function getMethod($name)
    {
        $method = $this->textClass->getMethod($name);

        $method->setAccessible(true);

        return $method;
    }

    protected function setUp(): void
    {
        $this->textClass = new \ReflectionClass(\Faker\Provider\el_GR\Text::class);
    }
}
