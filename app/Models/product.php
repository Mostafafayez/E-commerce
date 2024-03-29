<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
 use App\Models\users;



class Product extends Model
{
    protected $table = 'products';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'description',
        'category_id',
        'price',
        'primary_image', 
        'images',
        'users_id',
        'color',
        'size',
        'discount',
       'new_price', 
       'status'
    ];

    public function getNewPriceAttribute()
    {
        return $this->price * (1 - ($this->discount / 100));
    }



    const STATUS_WAITING = 0;
    const STATUS_ACCEPTED = 1;
    const STATUS_REJECTED = -1;

    protected $casts = [
        'images' => 'array', 
        'color'=> 'array',
        'size'=> 'array'
    ];

    protected $appends = ['full_src', 'full_src2'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function owner()
    {
        return $this->belongsTo(users::class, 'user_id');
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
        };
    }


    public function orders()
    {
        return $this->hasMany(Order::class);
    }


    
    }





