<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Subcription
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subcription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subcription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subcription query()
 * @mixin \Eloquent
 */
class Subcription extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        
        'subscribe_date',
        'unsubscribe_date',
        'msisdn',
        'product_id'
    ];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
