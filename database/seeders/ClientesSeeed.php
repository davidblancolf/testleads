<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClientesSeeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Client::create([
            ''=>'Nombre duplicado',
            ''=>'Apellido duplicado',
            'email'=>'duplicado@yopmail.com'
        ]);
    }
}
