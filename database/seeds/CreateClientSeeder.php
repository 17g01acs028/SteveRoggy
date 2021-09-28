<?php

use Illuminate\Database\Seeder;
use App\Client;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     Client::create([
        'clientName' => 'SynqAfrica',
        'clientAddress' => 'Nairobi',
        'mobileNo' => '254700000000',
        'accType' => '1',
        'accBalance' => '0',
        'accStatus' => '1',
        'httpDlrUrl' => '',
        'dlrHttpMethod' => '',
        'created_at' => '2020-06-28 21:15:48',
        'updated_at' => '2020-06-28 21:15:48',
      ]);

    }
}
