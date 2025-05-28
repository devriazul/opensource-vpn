<?php

namespace Database\Seeders;

use App\Models\VpnServer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VpnServerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $servers = [
            [
                'name' => 'US East',
                'ip_address' => 'us-east.yourdomain.com',
                'country' => 'United States',
                'port' => 1194,
                'protocol' => 'udp',
                'is_active' => true,
            ],
            [
                'name' => 'US West',
                'ip_address' => 'us-west.yourdomain.com',
                'country' => 'United States',
                'port' => 1194,
                'protocol' => 'udp',
                'is_active' => true,
            ],
            [
                'name' => 'Europe',
                'ip_address' => 'eu.yourdomain.com',
                'country' => 'Netherlands',
                'port' => 1194,
                'protocol' => 'udp',
                'is_active' => true,
            ],
            [
                'name' => 'Asia',
                'ip_address' => 'asia.yourdomain.com',
                'country' => 'Singapore',
                'port' => 1194,
                'protocol' => 'udp',
                'is_active' => true,
            ],
        ];

        foreach ($servers as $server) {
            VpnServer::create($server);
        }
    }
}
