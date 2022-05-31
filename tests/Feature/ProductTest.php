<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    //use RefreshDatabase;

    /**
     * Product creation test
     *
     * @return void
     */
    public function test_product_creation_returns_a_successful_response()
    {
        $response = $this->postJson('/api/product', [
            'description' => 'This is a test product',
            'price' => '400.00',
            'active' => 1
        ]);

        $response->assertStatus(201);
    }

    /**
     * Product validator test
     *
     * @return void
     */
    public function test_product_validation()
    {
        $response = $this->postJson('/api/product', [
            'description' => 'Test product',
            'price' => 'should fail',
            'active' => 1
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['price' => 'The price must be a number.']);
    }

    /**
     * Product listing test
     *
     * @return void
     */
    public function test_product_listing()
    {
        $response = $this->getJson('/api/product');

        $response->assertStatus(200);
        $response->assertExactJson(
            [
                'data' => 
                [
                    [
                        'active' => 1,
                        'description' => 'This is a test product',  
                        'price' => '400.00',
                        'id' => 1
                    ]
                ]
            ]
        );
    }
}
