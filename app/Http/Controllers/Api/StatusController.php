<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Support\Facades\DB;

use Log;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $status = DB::table('statuses')->pluck('name');

        $statuses = array();
        foreach ($status as $name) {
            $next = app()->make('stdClass');
            $next->text = $name;
            $next->value = $name;

            $statuses[] = $next;
        }

        return $statuses;
    }
}
