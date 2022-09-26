<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_making_an_api_request()
    {
        $data = [
        "update_id" => 644397699, 
        "message" => [
                "message_id" => 11, 
                "from" => [
                    "id" => 494963311, 
                    "is_bot" => false, 
                    "first_name" => "Валентин", 
                    "username" => "aboutvolleybal", 
                    "language_code" => "ru" 
                ], 
                "chat" => [
                    "id" => 494963311, 
                    "first_name" => "Валентин", 
                    "username" => "aboutvolleybal", 
                    "type" => "private" 
                    ], 
                "date" => 1663686223, 
                "text" => "test"
            ] 
        ];
        $response = $this->postJson('/api/en-fi/test', $data);
        $response
            ->assertStatus(200);
    }

}