<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryItems extends Model
{
    use HasFactory;

    protected $table = 'category_items';

    protected $guarded = [''];
}
