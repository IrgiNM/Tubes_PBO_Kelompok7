<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    protected $table = 'users';

    public function order()
    {
        return $this->hasMany(Order::class, 'id_customer');
    }
}
