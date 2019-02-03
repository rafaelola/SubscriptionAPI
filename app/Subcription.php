<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
    
    /**
     * @param int $msisdn
     *
     * @return Subcription[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection|null
     */
    public static function findByMsisdn($msisdn)
    {
        $sub = self::where('msisdn',$msisdn)
            ->whereNotNull('subscribe_date')
            ->where('deleted_at', null)
            ->get(['id']);
        $sub->fresh();
       if(\count($sub)=== 0){
           return null;
       }
       return $sub;
    }
    
    
    public static function findByMsisdnProId($msisdn,$product_id)
    {
        $sub = self::where('msisdn',$msisdn)
            ->where('product_id',$product_id)
            ->whereNotNull('subscribe_date')
            ->where('deleted_at', null)
            ->get(['id']);
        $sub->fresh();
        if(\count($sub)=== 0){
            return null;
        }
        return $sub;
    }
}
