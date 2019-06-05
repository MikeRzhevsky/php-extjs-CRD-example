<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\User_city_link;
use App\Models\User_education_link;
use App\Models\Education;
use Response;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function load()
    {
        $users = User::getUsers() ;

        return $users;
    }

    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        
        if($data['name'] )
        {
            $userId = User::insertGetId(['name'=>$data['name'],'email'=>$data['email']]);
            $citylinkid = User_city_link::createLink($data['City'],$userId);
            $educationlinkid = User_education_link::createLink($data['level'],$userId);

            if($userId)
                return  strval($data['name']);

            return null;
        }
    }

    public function delete(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if($data['userid']) {
            $user = User::where('id', '=', $data['userid']);
            $user->delete();
        }
    }
}
