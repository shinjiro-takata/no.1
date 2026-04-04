<?php

namespace Tests\Feature;

use Tests\TestCase;

class RegisterValidationTest extends TestCase
{
    public function test_register_requires_name_email_and_password(): void
    {
        $response = $this->from('/register')->post('/register', [
            'name' => '',
            'email' => '',
            'password' => '',
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }
}
