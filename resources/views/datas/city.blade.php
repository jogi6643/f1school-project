@if(count($city)>0)
	@foreach($city as $c)
		<option  @if(in_array($c->id,$citys)) selected @endif value="{{$c->id}}"> {{$c->name}} ( {{$c->names}} )</option>

	@endforeach
@endif