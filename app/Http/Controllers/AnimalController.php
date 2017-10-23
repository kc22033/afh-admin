<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use Log;

class AnimalController extends Controller
{
    //
    public function index()
    {
    	return view('animals');
    }

    public function clone(Request $request, $id)
    {
		Log::info('clone id = ' . $id);
		$animal = Animal::find($id);
		$clone = $animal->replicate();
		$clone->name = " ";
		$clone->rescue_groups_id = 0;
		$clone->origin_id = "";
		$clone->save();
		$id = $clone->id;
		$species = $clone->species;
		Log::info('new clone id = ' . $id . ' species: ' . $species);

        return redirect()->action('AnimalController@edit', ['id' => $id, 'species' => $species]);
    }

    public function edit(Request $request)
    {
        $species = $request->query('species');
        $id = $request->query('id');

        return view('edit', compact(['id', 'species']));
    }
}
