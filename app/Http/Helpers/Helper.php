

<?php

class Helper{


	public static function getState($data){

	$result = DB::table('locations')
	->where('Zone_id', $data)
	->where('Zone_id', '!=','')
    ->leftjoin('tbl_state','locations.state','=','tbl_state.id')
    ->groupBy('locations.state')
	->where('status',1)
    ->select('tbl_state.name as state_name', 'tbl_state.id as state_id')
    ->get();

    return $result;

	}

	public static function getCity($data){

	$result = DB::table('locations')
	->where('Zone_id', $data)
	->where('Zone_id', '!=','')
	->leftjoin('tbl_city','locations.city','=','tbl_city.id')
	->where('status',1)
    ->select('tbl_city.name as city_name', 'tbl_city.id as city_id')
    ->get();

    return $result;

	}


}