<p>Hello. Somebody wishes to use the Edible Giving manage area.</p>

<ul>
@foreach($input as $k=>$v)
	<li><em>{{$k}}:</em> {{$v}}</li>
@endforeach
</ul>

<p>Go to {{link_to('manage/power/users/' . $input['name_first'], 'the power area')}} to alter their roles.</p>