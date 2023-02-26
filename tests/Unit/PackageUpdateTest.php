<?php

namespace Tests\Unit;

use App\Models\Package;
use Tests\TestCase;

class PackageUpdateTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $value = [
            "transaction_id"=> "d0090c40-539f-479a-8274-899b9970bddc",
            "customer_name"=> "PT. AMARA PRIMATIGA",
            "customer_code"=> "1678593",
            "transaction_amount"=> "70700",
            "transaction_discount"=> "0",
            "transaction_additional_field"=> "",
            "transaction_payment_type"=> "29",
            "transaction_state"=> "PAID",
            "transaction_code"=> "CGKFT20200715121",
            "transaction_order"=> 121,
            "location_id"=> "5cecb20b6c49615b174c3e74",
            "organization_id"=> 6,
            "created_at"=> "2020-07-15T11:11:12+0700",
            "updated_at"=> "2020-07-15T11:11:22+0700",
            "transaction_payment_type_name"=> "Invoice",
            "transaction_cash_amount"=> 0,
            "transaction_cash_change"=> 0,
            "customer_attribute"=> [
                "Nama_Sales"=> "Radit Fitrawikarsa",
                "TOP"=> "14 Hari",
                "Jenis_Pelanggan"=> "B2B"
            ],
            "connote_id"=> "f70670b1-c3ef-4caf-bc4f-eefa702092ed",
            "origin_data"=> [
                "customer_name"=> "PT. NARA OKA PRAKARSA",
                "customer_address"=> "JL. KH. AHMAD DAHLAN NO. 100, SEMARANG TENGAH 12420",
                "customer_email"=> "info@naraoka.co.id",
                "customer_phone"=> "024-1234567",
                "customer_address_detail"=> null,
                "customer_zip_code"=> "12420",
                "zone_code"=> "CGKFT",
                "organization_id"=> 6,
                "location_id"=> "5cecb20b6c49615b174c3e74"
            ],
            "destination_data"=> [
                "customer_name"=> "PT AMARIS HOTEL SIMPANG LIMA",
                "customer_address"=> "JL. KH. AHMAD DAHLAN NO. 01, SEMARANG TENGAH",
                "customer_email"=> null,
                "customer_phone"=> "0248453499",
                "customer_address_detail"=> "KOTA SEMARANG SEMARANG TENGAH KARANGKIDUL",
                "customer_zip_code"=> "50241",
                "zone_code"=> "SMG",
                "organization_id"=> 6,
                "location_id"=> "5cecb20b6c49615b174c3e74"
            ],
            "custom_field" => [
                "catatan_tambahan" => "JANGAN DI BANTING \/ DI TINDIH"
            ],
            "currentLocation"=> [
                "name"=> "Hub Jakarta Selatan",
                "code"=> "JKTS01",
                "type"=> "Agent"
            ]
        ];
        $id = Package::with('connote','koli_data')->get()[0]['_id'];
        $this->put(route('packages.update',['id' => $id]),$value)->assertStatus(200);
    }

}
