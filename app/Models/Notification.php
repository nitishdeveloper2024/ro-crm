<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'is220',
        'is330'
    
    ];
}
