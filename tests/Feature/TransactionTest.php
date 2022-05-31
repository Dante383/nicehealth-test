<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    /**
     * Transaction inserting test
     *
     * @return void
     */
    public function test_create_transactions_returns_a_successful_response()
    {
        $response = $this->postJson('/api/transaction', 
        [
            'amount' => '490.00',
            'status' => 0,
            'subscription_id' => 1
        ]);

        $response->assertStatus(201);
    }

    /**
     * Transaction validator test
     *
     * @return void
     */
    public function test_transaction_validation()
    {
        $response = $this->postJson('/api/transaction', 
        [
            'amount' => 'should fail',
            'status' => 'should fail',
            'subscription_id' => 99999
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['subscription_id' => 'Subscription with that ID doesn\'t exist.']);
        $response->assertJsonValidationErrors(['amount' => 'Amount has to be a number.']);
        $response->assertJsonValidationErrors(['status' => 'Status has to be either 0 or 1.']);
    }

    /**
     * Transaction listing test
     *
     * @return void
     */
    public function test_transaction_listing()
    {
        $response = $this->getJson('/api/transaction');

        $response->assertStatus(200);
        $response->assertJson(
            [
                'data' => [
                    [
                        'id' => 1, 
                        'amount' => '490.00', 
                        'status' => 0, 
                        'subscription' => [
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
                        ]
                    ]
                ]
            ]
        );
    }
}
