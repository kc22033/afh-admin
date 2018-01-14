<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Breed;
use App\Models\Species;
use Illuminate\Support\Facades\DB;

use Log;

class BreedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request, $species = 'Dog')
    {
        $speciesList = config('afh.species_list');
        if ( in_array( $species, $speciesList ) )
        {
            $species = Species::where('name', $species)->orderBy('name')->firstOrFail();
            
            $breed = DB::table('breeds')->where('species_id', $species->id)->pluck('name');
            
            $breeds = array();
            foreach ($breed as $name) {
                $next = app()->make('stdClass');
                $next->text = $name;
                $next->value = $name;
                
                $breeds[] = $next;
            }
            return response()->json($breeds);
        } else {
            return response()->json([
                'message' => 'Invalid Request.',
            ], 404);
        }
    }
}
