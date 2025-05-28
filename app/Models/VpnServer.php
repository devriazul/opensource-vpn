<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VpnServer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ip_address',
        'country',
        'port',
        'protocol',
        'is_active'
    ];

    public function connections()
    {
        return $this->hasMany(UserVpnConnection::class);
    }
}
