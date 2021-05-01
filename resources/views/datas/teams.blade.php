@if(count($teams1)>0)
	 @foreach($teams1 as $tid)
                     <option value="{{$tid->tmpid}}" @if(in_array($tid->tmpid,$teamid))selected @endif>{{$tid->teamname}} </option>
          @endforeach
@endif