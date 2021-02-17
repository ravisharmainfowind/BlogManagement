@include('admin.layouts.head')

	<body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
		
		@include('admin.layouts.header')
		
		@include('admin.layouts.sidebar')

		@if(Session::has('success'))
            <script type="text/javascript">
                swal({
                    title: "Success",
                    text: "{{Session::get('success')}}",
                    timer: 5000,
                    type: 'success'
                }).then((value) => {
                    //location.reload();
                }).catch(swal.noop);
            </script>
            @endif
            @if(Session::has('fail'))
            <script type="text/javascript">
                swal({
                    title: "Opps!",
                    text: "{{Session::get('fail')}}",
                    type: 'error',
                    timer: 5000
                }).then((value) => {
                    //location.reload();
                }).catch(swal.noop);
            </script>
            @endif

		<div class="content-wrapper">


            @if (session()->get('success'))
                @php
                    $type = 'success';
                @endphp
                @if(is_array(json_decode(session()->get('success'), true)))
                    @php
                        $message = implode('', session()->get('success')->all(':message<br/>'));
                    @endphp
                @else
                    @php
                        $message = session()->get('success');
                    @endphp
                @endif
            @elseif (session()->get('warning'))
                @php
                    $type = 'warning';
                @endphp
                @if(is_array(json_decode(session()->get('warning'), true)))
                    @php
                        $message = implode('', session()->get('warning')->all(':message<br/>'));
                    @endphp
                @else
                    @php
                        $message = session()->get('warning');
                    @endphp
                @endif
            @endif



			@yield('content')

			@include('admin.layouts.footer')

		</div>
	</body>
    @yield('js')
</html>


