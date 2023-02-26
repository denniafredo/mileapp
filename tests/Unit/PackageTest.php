<?php

namespace Tests\Unit;

use Tests\TestCase;

class PackageTest extends TestCase
{
    public function test_example()
    {
        $this->get("/api/packages")->assertStatus(200);
    }
}
