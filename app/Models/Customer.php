<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    protected $table = 'customer';
    protected $primaryKey = 'c_id';
    
    use Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'c_password',
    ];

    public function getAuthPassword()
    {
        return $this->c_password;
    }
}