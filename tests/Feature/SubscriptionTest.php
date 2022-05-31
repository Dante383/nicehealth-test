<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class SubscriptionTest extends TestCase
{
    /**
     * Subscription creation test
     *
     * @return void
     */
    public function test_create_subscription_returns_a_successful_response()
    {
        $response = $this->postJson('/api/subscription', [
            'product_id' => 1,
            'customer_id' => 1,
            'name' => 'Humira subscription',
            'active' => 1
        ]);

        $response->assertStatus(201);
    }

    /**
     * Subscription validator test
     *
     * @return void
     */
    public function test_subscription_validation()
    {
        $response = $this->postJson('/api/subscription', [
            'product_id' => 999999,
            'customer_id' => 99999,
            'name' => 'Humira subscription',
            'active' => 1
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['product_id' => 'Product with that ID doesn\'t exist.']);
        $response->assertJsonValidationErrors(['customer_id' => 'Customer with that ID doesn\'t exist.']);
    }

    /**
     * Subscription listing test
     *
     * @return void
     */
    public function test_subscription_listing()
    {
        $response = $this->getJson('/api/subscription');

        $response->assertStatus(200);
        $response->assertJson(
            [
                'data' => 
                [
                    [
                        'id' => 1, 
                        'active' => 1,
                        'product' => 
                        [
                                'id' => 1, 
                                'description' => 'This is a test product', 
                                'price' => '400.00',
                                'active' => 1
                        ],
                        'customer' => 
                        [
                            'id' => 1,
                            'first_name' => 'John',
                            'last_name'  => 'Doe',
                            'email'      => 'john.doe@example.com'
                        ]
                    ],
                ]
            ]
        );
    }
}
