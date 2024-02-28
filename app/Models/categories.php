<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    use HasFactory;

    protected $table = 'categories'; 
   public  $time_stamp=false;
   protected $appends = ['full_src'];
   public function getFullSrcAttribute(): string
   {
       return asset('storage/'.$this->image);
   }
   
}


