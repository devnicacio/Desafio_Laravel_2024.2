<?php

namespace Tests\Unit;

use App\Models\Admin;
use Auth;
use Tests\TestCase;

class ManagerTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function test_create_authenticated()
    {
        $admin = Admin::factory()->create();
        Auth::login($admin);
        $response = $this->actingAs($admin)->post('/admin-create-manager',[
            'name' => "João Victor",
            'email' => "victor@nicacio",
            'country' => "Brasil",
            'postalCode' => "36703090",
            'state' => "Minas Gerais",
            'city' => "Juiz de Fora",
            'neighborhood' => "Bela Vista",
            'street' => "Santo Antônio",
            'number' => 123,
            'complement' => "",
            'phoneNumber'=> "32988232671",
            'birthdate' => "2000-09-21",
            'cpf' => "132.402",
            'photo' => 'images/safebank-default-profile-photo.png',
            'password' => "123",
            'agency' => "1234",
            'transferLimit' => 12.54
        ]);

        $response->assertStatus(302);
    }
}
