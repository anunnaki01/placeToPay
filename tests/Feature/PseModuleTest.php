<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PseModuleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_can_view_transactions()
    {
        $user = factory(User::class)->make();
        $response = $this->actingAs($user)->get('/transactions');
        $response->assertSee('Mis transacciones');
    }

    public function test_user_can_view_form_pse()
    {
        $user = factory(User::class)->make();
        $response = $this->actingAs($user)->get('/pse');
        $response->assertSee('Pagos en Linea');
    }
}
