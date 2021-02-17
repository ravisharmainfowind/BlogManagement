@if($profile_picture)
	<img src="{{ asset('public/'.$profile_picture) }}" height="70px" width="70px">
@else
	<img src="{{ asset('public/no-image.png') }}" height="70px" width="70px">
@endif