<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $table = 'products';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'price',
        'image',
        'user_id' // Assuming this is the foreign key for the owner relationship
    ];

    protected $appends = ['full_src'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(categories::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(users::class, 'user_id');
    }

    public function getFullSrcAttribute(): string
    {
        return asset('storage/'.$this->image);
    }
}

