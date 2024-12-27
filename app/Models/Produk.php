<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    public function order()
    {
        return $this->hasMany(Order::class, 'id_customer');
    }
}
