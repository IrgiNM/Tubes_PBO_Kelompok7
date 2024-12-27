<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_customer');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }


}
