<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'idescription', 'price', 'category', 'created_at', 'updated_at'];
    protected $dates = 'deleted_at';

    public function catgeory()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderIem()  
    {
        return $this->belongsTo(OrderItem::class);
    }
}
