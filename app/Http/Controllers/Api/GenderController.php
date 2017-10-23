<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Log;

class GenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $genders = [
            'Female',
            'Male',
            'Unknown'
        ];

        $genderList = array();
        foreach ($genders as $gender) {
            $next = app()->make('stdClass');
            $next->text = $gender;
            $next->value = $gender;

            $genderList[] = $next;
        }

        return $genderList;
    }
}
