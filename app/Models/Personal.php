<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable = [
        'username',
        'email',
        'phone',
        'created_at'
    ];
}
//protected $fillable = ['name', 'created_at']; 