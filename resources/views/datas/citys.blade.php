@if(count($city)>0)
	@foreach($city as $c)
		<option value="{{$c->id}}"> {{$c->name}} ( {{$c->names}} )</option>

	@endforeach
@endif