<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VpnConfiguration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client_name',
        'config_file_path',
        'status',
        'last_connected_at'
    ];

    protected $casts = [
        'last_connected_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
