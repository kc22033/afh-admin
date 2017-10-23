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
    public function index(Request $request)
    {
        //
        Log::info('Species.index >>>' . $request->query('species') . '<<<');
        $species = Species::where('name', $request->query('species'))->orderBy('name')->firstOrFail();
        // Log::info('Species: ' . $species->id);

        $breed = DB::table('breeds')->where('species_id', $species->id)->pluck('name');

        $breeds = array();
        foreach ($breed as $name) {
            $next = app()->make('stdClass');
            $next->text = $name;
            $next->value = $name;

            $breeds[] = $next;
        }
        return $breeds;
    }
}
