<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories'; 
    public $timestamps = false; // Correct property name and value to disable timestamps

    protected $fillable = [
        'name',
        'image',
    ];

    protected $appends = ['full_src'];
   
    public function getFullSrcAttribute(): string
    {
        return asset('storage/'.$this->image);
    }
}
   