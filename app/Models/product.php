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
        'primary_image', 
        'images',
        'user_id'
    ];

    protected $casts = [
        'images' => 'array', 
    ];

    protected $appends = ['full_src', 'full_src2'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getFullSrcAttribute()
    {
        if (!empty($this->primary_image)) {
            // Assuming you want to display the first image in the list
            return asset('storage/'.$this->primary_image);
        } else {
            return ''; // Return empty string if no images are available
        }
    }

    public function getFullSrc2Attribute()
    {
        if (!empty($this->images)) {
            $imageUrls = [];
            foreach ($this->images as $image) {
                $imageUrls[] = asset('storage/'.$image);
            }
            return $imageUrls;
        } else {
            return []; // Return empty array if no images are available
        }
    }




}

