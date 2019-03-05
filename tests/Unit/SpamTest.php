<?php

namespace Tests\Unit;

use App\Spam;
use Tests\TestCase;

class SpamTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function test_it_checks_invalid_keyWords()
    {
        $this->withoutExceptionHandling();
        $spam = new Spam();

        $this->assertFalse($spam->detect('Innocent reply here'));

        $this->expectException(\Exception::class);

        $spam->detect('yahoo customer support');
    }

    /**
     * @throws \Exception
     */
    public function test_it_checks_any_key_being_held_down()
    {
        $this->withoutExceptionHandling();
        $spam = new Spam();


        $this->expectException(\Exception::class);

        $spam->detect('Hello world aaaaa');
    }
}
