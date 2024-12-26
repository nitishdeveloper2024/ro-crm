<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    //
    use HasFactory;

    // Specify the fillable attributes
    protected $fillable = [
        'c_name',
        'c_mobile',
        'c_alt_mobile',
        'c_address',
        'c_email',
        'c_pin_code',
        'product_id',
        'mrp',
        'qty',
        'price',
        'discount',
        'final_amt',
        'pdf_path',
        'status',
        'image',
        'installed_by',
        'invoicenumber',
        'billed_date',
        'payment',
        // 'pdf_path'
    ];

}
