<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderDetails extends Pivot

{
    protected $fillable = ['user_id', 'order_id', 'discount'];

    public $timestamps = false;
}

