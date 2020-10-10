<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $guarded = [
        'id',
        'deleted_at'
    ];

    protected $hidden = [
        'quantity'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
