@if($feature_image)
	<img src="{{ asset('public/'.$feature_image) }}" height="70px" width="70px">
@else
	<img src="{{ asset('public/no-image.png') }}" height="70px" width="70px">
@endif