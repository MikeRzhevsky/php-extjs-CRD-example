<?php

namespace App\Http\Controllers;

use App\Models\Education;

class EducationController extends Controller
{
    public function load()
    {
        $education = Education::get()->toArray();

        return $education;//trim(json_encode($education),'[]');
    }

}
