<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVpnConnection extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vpn_server_id',
        'connection_id',
        'status',
        'client_ip',
        'connected_at',
        'disconnected_at'
    ];

    protected $casts = [
        'connected_at' => 'datetime',
        'disconnected_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function server()
    {
        return $this->belongsTo(VpnServer::class, 'vpn_server_id');
    }
}
