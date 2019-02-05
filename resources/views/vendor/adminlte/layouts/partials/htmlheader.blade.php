<head>
    <meta charset="UTF-8">
    <title> AdminLTE 2 with Laravel - @yield('htmlheader_title', 'Your title here') </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('/css/all.css') }}" rel="stylesheet" type="text/css" />
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel = "stylesheet" href=  "https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.6/jquery.fancybox.css" />
    <link rel= "stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.6/jquery.fancybox.min.css" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .progress { position:relative; width:100%; border: 1px solid #7F98B2; padding: 1px; border-radius: 3px; }
        .bar { background-color: #B4F5B4; width:0%; height:25px; border-radius: 3px; }
        .percent { position:absolute; display:inline-block; top:3px; left:48%; color: #7F98B2;}
    </style>

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
