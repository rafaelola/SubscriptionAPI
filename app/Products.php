<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Products
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Products newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Products newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Products query()
 * @mixin \Eloquent
 */
class Products extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','product_by_user_id'
    ];
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
