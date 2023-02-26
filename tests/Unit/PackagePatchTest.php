<?php

namespace Tests\Unit;

use App\Models\Package;
use Tests\TestCase;

class PackagePatchTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $value = [
            "customer_name"=> "PT. AMIRA",
        ];
        $id = Package::with('connote','koli_data')->get()[0]['_id'];
        $this->patch(route('packages.update',['id' => $id]),$value)->assertStatus(200);
    }

}
