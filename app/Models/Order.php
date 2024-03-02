<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;
use App\Models\Users;
class Order extends Model
{
    protected $table = 'orders';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'quantity'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(users::class);
    }
    
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(products::class, 'order_product', 'order_id', 'product_id')
            ->withPivot('quantity', 'discount');
    }
}






