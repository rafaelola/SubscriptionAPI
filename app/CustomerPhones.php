<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CustomerPhones
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CustomerPhones newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CustomerPhones newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CustomerPhones query()
 * @mixin \Eloquent
 */
class CustomerPhones extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone_no','display_name'
    ];
    
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at','delete_reason'
    ];
}
