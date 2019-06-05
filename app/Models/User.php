<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','created_at','updated_at','id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getUsers()
    {
        return DB::table('users')
            ->selectRaw('users.id as userid, users.name as name, users.email as email, 
                         education.level as education , city.name as city')
            ->leftJoin('user_education_link', 'user_education_link.userid','=','users.id')
            ->leftJoin('education', 'education.id','=','user_education_link.educationid')
            ->leftJoin('user_city_link', 'user_city_link.userid','=','users.id')
            ->leftJoin('city', 'city.id','=','user_city_link.cityid')
            ->get()
            ->toArray();
    }
}
