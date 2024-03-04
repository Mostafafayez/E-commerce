<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;
use App\Models\uusers;
use App\Models\Product;
class Order extends Model
{
    protected $table = 'orders';
    public $timestamps = false;

    protected $fillable = ['users_id', 'product_id', 'quantity'];

    
    public function user()
    {
        return $this->belongsTo('App\Models\uusers', 'users_id');
    }
    
    public function Product()
    {
        return $this->belongsTo('App\Models\product','product_id');
    }
    
}






