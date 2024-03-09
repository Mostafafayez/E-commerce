<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otps extends Model
{
    use HasFactory;


    protected $table = 'otps';
    protected $primaryKey = 'id';

    protected $fillable = [
        'phone',
        'otp',
        'expires_at',
        'created_at',
        'updated_at',
    ];
}
