<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Species;
use Illuminate\Support\Facades\DB;

use Log;

class SpeciesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        // $species = Species::all();
        $species = DB::table('species')->pluck('name');

        $speciesList = array();
        foreach ($species as $name) {
            $next = app()->make('stdClass');
            $next->text = $name;
            $next->value = $name;

            $speciesList[] = $next;
        }
        return $speciesList;
    }
}
