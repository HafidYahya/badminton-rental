<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'p_id';
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'p_customer_id', 'c_id');
    }

    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class, 'p_lapangan_id', 'l_id');
    }
}
