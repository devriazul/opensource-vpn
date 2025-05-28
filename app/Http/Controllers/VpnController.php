<?php

namespace App\Http\Controllers;

use App\Models\VpnServer;
use App\Models\VpnConfiguration;
use App\Models\UserVpnConnection;
use App\Services\OpenVpnService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VpnController extends Controller
{
    protected $openVpnService;

    public function __construct(OpenVpnService $openVpnService)
    {
        $this->openVpnService = $openVpnService;
    }

    public function index()
    {
        $servers = VpnServer::where('is_active', true)->get();
        $configurations = auth()->user()->vpnConfigurations;
        $connections = auth()->user()->vpnConnections()->with('server')->get();

        return view('vpn.index', compact('servers', 'configurations', 'connections'));
    }

    public function createConfiguration(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
        ]);

        $config = auth()->user()->vpnConfigurations()->create([
            'client_name' => $request->client_name,
            'config_file_path' => 'vpn/configs/' . Str::random(40) . '.ovpn',
            'status' => 'active'
        ]);

        $this->openVpnService->generateClientConfig($config);

        return redirect()->route('vpn.index')->with('success', 'VPN configuration created successfully.');
    }

    public function connect(Request $request)
    {
        $request->validate([
            'server_id' => 'required|exists:vpn_servers,id',
        ]);

        $server = VpnServer::findOrFail($request->server_id);
        
        $connection = auth()->user()->vpnConnections()->create([
            'vpn_server_id' => $server->id,
            'connection_id' => Str::random(40),
            'status' => 'connecting',
            'connected_at' => now()
        ]);

        $this->openVpnService->establishConnection($connection);

        return redirect()->route('vpn.index')->with('success', 'Connecting to VPN server...');
    }

    public function disconnect(Request $request)
    {
        $request->validate([
            'connection_id' => 'required|exists:user_vpn_connections,connection_id'
        ]);

        $connection = auth()->user()->vpnConnections()
            ->where('connection_id', $request->connection_id)
            ->firstOrFail();

        $this->openVpnService->terminateConnection($connection);

        return redirect()->route('vpn.index')->with('success', 'Disconnected from VPN server.');
    }
}
