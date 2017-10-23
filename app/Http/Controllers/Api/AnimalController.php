<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\AnimalList;
use App\Models\Status;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Validator;

use Log;

class AnimalController extends Controller
{
    private $animalListExclusions = [
        'is_va_releasing_agency',
        'created_at',
        'updated_at',
        'color',
        'origin_id',
        'origin',
        'narrative',
        'status_date'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $status = $request->query('status');
        $species = $request->query('species');
        $orderBy = $request->query('orderBy');
        $sortOrder = $request->query('sortOrder');

        if( empty( $status )) { $status = "Available"; }
        if( empty( $species )) { $species = "Dog"; }
        if( empty( $orderBy )) { $orderBy = "name"; }
        if( empty( $sortOrder )) { $sortOrder = "asc"; }

        Log::info('Api/AnimalController.index - status: ' . $status . ' / species: ' . $species . ' / orderBy: ' . $orderBy . ' / sortOrder: ' . $sortOrder);

        $animals = Animal::exclude($this->animalListExclusions)
            ->where
            ([
                ['status', '=', $status],
                ['species', '=', $species]
            ])
            ->orderBy($orderBy, $sortOrder)
            ->get();

        return $animals;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return new Animal;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($id == 0) {
            $animal = new Animal;
        } else {
            $animal = Animal::find($id);
        }

        return $animal;
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Log::debug('edit id: ' . $id);
        if ($id == 0) {
            $animal = new Animal;
        } else {
            $animal = Animal::find($id);
        }

        return $animal;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Log::debug('update id: ' . $id . ': image_file = ' . $request->image_file);
        if ($id == 0) {
            $animalToUpdate = new Animal;
        } else {
            $animalToUpdate = Animal::find($id);
        }

        $animalToUpdate->species = $request->species;
        $animalToUpdate->pri_breed = $request->pri_breed;
        $animalToUpdate->sec_breed = $request->sec_breed ?: "";
        
        if ($animalToUpdate->status != $request->status) {
            $animalToUpdate->status = $request->status;
            $animalToUpdate->status_date = date("Y-m-d");
        };
        $animalToUpdate->mix = $request->mix ?: true;
        $animalToUpdate->date_of_birth = $request->date_of_birth;
        $animalToUpdate->intake_date = $request->intake_date;
        $animalToUpdate->sex = $request->sex;
        $animalToUpdate->origin = $request->origin ?: "";
        $animalToUpdate->origin_id = $request->origin_id ?: "";
        $animalToUpdate->is_va_releasing_agency = $request->is_va_releasing_agency ?: false;
        $animalToUpdate->altered = $request->altered ?: false;
        $animalToUpdate->weight = $request->weight ?: 0;
        $animalToUpdate->name = $request->name;
        $animalToUpdate->image_file = $request->image_file;
        $animalToUpdate->color = $request->color ?: "";
        $animalToUpdate->tagnum = $request->tagnum ?: "";
        $animalToUpdate->foster = $request->foster ?: "";
        $animalToUpdate->narrative = $request->narrative;

        $animalToUpdate->save();
    }

    /**
     * Update the status of the specified animal in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, Animal $animal)
    {
        $status = $request->input('status');

        $statusList = Status::pluck('name');
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:' . implode(",", $statusList->toArray()),
        ]);


        if ($validator->fails()) {
            Log::error('Invalid Status provided to updateStatus: ' . $status);
            return response('Invalid Status Provided', 400);
        } else {
            $animal->status = $status;
            $animal->status_date = date("Y-m-d");
            $animal->save();
            $refresh = AnimalList::where('status', $status)->get();
            return $animal;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Animal $animal)
    {
        $animal->delete();
        return "";
    }

}
