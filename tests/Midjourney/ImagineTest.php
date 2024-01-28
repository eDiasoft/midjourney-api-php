<?php

namespace Tests\Midjourney;

class Imagine extends MidjourneyTestCase 
{
    /**
     * @return void
     * @test
     */
    public function it_create_a_imagine_request()
    {
        $result = $this->midjourney->imagine('Elephant and a snake romantically having a diner')->send();

        $this->assertTrue(isset($result['id']));
    }
}