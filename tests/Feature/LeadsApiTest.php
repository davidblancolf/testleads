<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Lead;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeadsApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_index(): void
    {
        $response = $this->get('api/leads');

        $response->assertStatus(200);
    }

    public function test_lead_store()
    {
        $response = $this->post('api/leads', [
            'name' => 'John Marciano',
            'email' => 'johnmarciano@yopmail.com',
            'phone' => '1234567890',
        ]);
        $response->assertStatus(201);
    }
    public function test_lead_show()
    {
        $lead = Lead::where('name', 'John Marciano')
            ->where('email', 'johnmarciano@yopmail.com')->first()->id;
        $response = $this->get('api/leads/' . $lead);
        $response->assertStatus(200);
    }
    public function test_lead_update()
    {
        $lead = Lead::where('name', 'John Marciano')
        ->where('email', 'johnmarciano@yopmail.com')->first()->id;
        $response = $this->put('api/leads/'.$lead, [
            'name' => 'John Marciano 2 ',
            'email' => 'johnmarciano@yopmail.com',
            'phone' => '123447844',
        ]);
        $response->assertStatus(202);
    }
    public function test_lead_delete()
    {
        $lead = Lead::where('name', 'John Marciano 2')
            ->where('email', 'johnmarciano@yopmail.com')->first()->id;
        $response = $this->delete('api/leads/' . $lead);
        $response->assertStatus(202);
        $response = $this->delete('api/leads/' . $lead);
        $response->assertStatus(404);
    }
}
