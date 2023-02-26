<?php

namespace Tests\Unit;

use Tests\TestCase;

class PackageDeleteTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
   
    public function test_example()
    {
        $id = Self::generateRandomString(5);
        $this->get(route('packages.destroy',['id' => 1]))->assertStatus(200);
    }
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
