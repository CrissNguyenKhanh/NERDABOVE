<base href="{{ config('app.url') }}">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>INSPINIA | Dashboard v.2</title>

<!-- Sử dụng hàm asset để tạo liên kết động -->
<link href="{{ asset('backend/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
<link href="{{ asset('backend/css/animate.css') }}" rel="stylesheet">
<link href="{{ asset('backend/plugins/jquery-ui.css') }}" rel="stylesheet">

@if(isset($config['css']) && is_array($config['css']))
    @foreach($config['css'] as $key => $val)
        <link rel="stylesheet" href="{{ asset($val) }}">
    @endforeach
@endif

<link href="{{ asset('backend/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('backend/css/customize.css') }}" rel="stylesheet">

<!-- Sử dụng asset() cho file JavaScript -->
<script src="{{ asset('backend/js/jquery-3.1.1.min.js') }}"></script>
<script>
    var BASE_URL = '{{ config('app.url') }}';
    var SUFFIX = '{{ config('apps.general.suffix') }}';
</script>
