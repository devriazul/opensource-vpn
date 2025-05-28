<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('VPN Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- VPN Servers Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Available VPN Servers</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($servers as $server)
                            <div class="border rounded-lg p-4">
                                <h4 class="font-semibold">{{ $server->name }}</h4>
                                <p class="text-sm text-gray-600">{{ $server->country }}</p>
                                <p class="text-sm text-gray-600">IP: {{ $server->ip_address }}</p>
                                <form action="{{ route('vpn.connect') }}" method="POST" class="mt-2">
                                    @csrf
                                    <input type="hidden" name="server_id" value="{{ $server->id }}">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Connect
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Active Connections Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Active Connections</h3>
                    @if($connections->isEmpty())
                        <p class="text-gray-600">No active connections</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Server</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Connected Since</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($connections as $connection)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $connection->server->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $connection->status === 'connected' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ ucfirst($connection->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $connection->connected_at->diffForHumans() }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($connection->status === 'connected')
                                                    <form action="{{ route('vpn.disconnect') }}" method="POST" class="inline">
                                                        @csrf
                                                        <input type="hidden" name="connection_id" value="{{ $connection->connection_id }}">
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Disconnect</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- VPN Configurations Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Your VPN Configurations</h3>
                    <form action="{{ route('vpn.create-configuration') }}" method="POST" class="mb-4">
                        @csrf
                        <div class="flex gap-4">
                            <input type="text" name="client_name" placeholder="Enter client name" required
                                class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Create New Configuration
                            </button>
                        </div>
                    </form>

                    @if($configurations->isEmpty())
                        <p class="text-gray-600">No configurations found</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Connected</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($configurations as $config)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $config->client_name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $config->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                    {{ ucfirst($config->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $config->last_connected_at ? $config->last_connected_at->diffForHumans() : 'Never' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="#" class="text-blue-600 hover:text-blue-900">Download Config</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 