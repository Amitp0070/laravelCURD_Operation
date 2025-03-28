<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'product_categories'; // Table name define karna zaroori hai agar different ho
    protected $fillable = ['category_name', 'is_active', 'state'];
}
