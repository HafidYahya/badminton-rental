<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $guarded = [];

    protected $casts = [
        'amount' => 'integer',
        'fee' => 'integer',
        'total_payment' => 'integer',
        'is_sandbox' => 'boolean',
        'expires_at' => 'datetime',
        'completed_at' => 'datetime',
        'last_status_checked_at' => 'datetime',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id', 'p_id');
    }
}
