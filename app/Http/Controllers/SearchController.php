<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Search;
use App\AirData;

class SearchController extends Controller
{
    public function store(Request $request){


        \Log::info($request);

    	$user = \Auth::user();

    	$s = new Search();
    	$s->user_id = ($user) ? $user->id : null;
    	$s->guest_id = null;
    	$s->location = $request->location;
    	$s->save();


        $minLat = $request->lat - 0.02;
        $maxLat = $request->lat + 0.02;

    	$results = AirData::where(function($query) use ($minLat, $maxLat){
            $query
                ->where('lat', '>=', $minLat)
                ->where('lat', '<=', $maxLat);
    	})->get();

    	\Log::info([
    	    'minLat' => $minLat,
            'maxLat' => $maxLat
        ]);
        \Log::info($results);

    	return $results;
    }
}
