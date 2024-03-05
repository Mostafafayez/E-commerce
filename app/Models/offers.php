<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class offers extends Model
{
    
    use HasFactory;
public $timestamps =false ;
    protected $fillable = [
        'category_id',
        'image',
    ];
    protected $appends = ['full_src'];

    public function getFullSrcAttribute()
    {
        if (!empty($this->image)) {
        
            return asset('storage/'.$this->image);
        } else {
            return 'no image'; 
        }
    }

    


}


