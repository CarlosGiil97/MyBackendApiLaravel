<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class SeasonTest extends TestCase
{

    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function testCreateModel(): void
    {
        $season = new \App\Models\Season();
        $this->assertInstanceOf(\App\Models\Season::class, $season);
    }

    public function testFillable(): void
    {
        $season = new \App\Models\Season();
        $this->assertEquals(['year'], $season->getFillable());
    }
}
