<?php

namespace Tests\Feature;

use Tests\TestCase;

class OrderSuccessfulTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $payload = [
            "products" => [
                [
                    "product_id" => 1,
                    "quantity" => 1
                ]
            ]
        ];
        $response = $this->postJson('api/order', $payload);

        $response->assertStatus(200)
        ->assertJson([
            "status" => true,
            "message" => "Order created successfully"
        ]);
    }
}
