@if(count($teams1)>0)
	 @foreach($teams1 as $tid)
                     <option value="{{$tid->tmpid}}">{{$tid->teamname}} </option>
          @endforeach
@endif