<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\City;

class User_city_link extends Model
{
    protected $table = 'user_city_link';

    protected $fillable = ['userid','cityid'];

    const KEYFIELD = 'id';

    public static function createLink($cityid,$userId)
    {
        if($cityid && $userId)
        {
            return User_city_link::insertGetId(['cityid'=>$cityid,'userid'=>$userId]);
        }
    }
}
