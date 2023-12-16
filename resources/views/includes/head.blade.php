<head>
    <title>Voting App</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <meta name="description" content="Voting App" />
    <meta name="author" content="" />
    <meta name="keywords" content="Voting App" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    {{-- assets --}}
    <link rel="shortcut icon" type="image/png" href="{{asset('favicon.png')}}" />
    <link rel="stylesheet" href="{{asset('dashboard_assets/dist/libs/owl.carousel/dist/assets/owl.carousel.min.css')}}">
    <link  id="themeColors"  rel="stylesheet" href="{{asset('dashboard_assets/dist/css/style.min.css')}}" />

    {{-- specific page style --}}
    @stack('style')
  </head>