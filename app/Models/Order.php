<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;
use App\Models\Users;
use App\Models\Product;
class Order extends Model
{
    protected $table = 'orders';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'users_id',
        'quantity',
        'Product_id',
    ];

    
    public function user()
    {
        return $this->belongsTo('App\Models\Users', 'users_id');
    }
    
    public function Product()
    {
        return $this->belongsTo('App\Models\product','product_id');
    }
    
}






