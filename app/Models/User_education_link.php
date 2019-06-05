<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Education;

class User_education_link extends Model
{
    protected $table = 'user_education_link';

    protected $fillable = ['userid','educationid'];

    const KEYFIELD = 'id';

    public static function createLink($educationId,$userId)
    {
        if($educationId && $userId)
        {
            return User_education_link::insertGetId(['educationid'=>$educationId,'userid'=>$userId]);
        }
    }
}
