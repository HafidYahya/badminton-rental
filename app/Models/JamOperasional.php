<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JamOperasional extends Model
{
    protected $table='jam_operasional';
    protected $primaryKey = 'jo_id';

    protected $guarded = [];
}