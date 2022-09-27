<head>
    <meta charset="utf-8">
    {!! SEOMeta::generate() !!}
    <title>{{ $title ?? '' }}</title>
    <meta name="description" content="{{ $description ?? '' }}">
    <meta name="keywords" content="{{ $keywords ?? '' }}">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="/static/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/static/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/static/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="/static/images/favicon/site.webmanifest">
    <link rel="mask-icon" href="/static/images/favicon/safari-pinned-tab.svg" color="#0f5adb">
    <link rel="icon" type="image/svg+xml" href="/static/images/favicon/favicon.svg">
    <link rel="icon" type="image/png" href="/static/images/favicon/favicon.png">
    <link rel="shortcut icon" href="/static/images/favicon/favicon.ico">
    <meta name="apple-mobile-web-app-title" content="name">
    <meta name="application-name" content="name">
    <meta name="cmsmagazine" content="18db2cabdd3bf9ea4cbca88401295164">
    <meta name="author" content="Fanky.ru">
    <meta name="msapplication-TileColor" content="#603cba">
    <meta name="msapplication-config" content="/static/images/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    {!! OpenGraph::generate() !!}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="/static/fonts/Mulish-Regular.woff2" rel="preload" as="font" type="font/woff2" crossorigin="anonymous">
    <link href="/static/fonts/Mulish-Medium.woff2" rel="preload" as="font" type="font/woff2" crossorigin="anonymous">
    <link href="/static/fonts/Mulish-SemiBold.woff2" rel="preload" as="font" type="font/woff2" crossorigin="anonymous">
    <link href="/static/fonts/Mulish-Bold.woff2" rel="preload" as="font" type="font/woff2" crossorigin="anonymous">
    <link href="/static/fonts/Mulish-ExtraBold.woff2" rel="preload" as="font" type="font/woff2" crossorigin="anonymous">
    <link href="/static/fonts/Mulish-Black.woff2" rel="preload" as="font" type="font/woff2" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="{{ mix('static/css/all.css') }}" media="all">
    <!-- jQuery 3 -->
    <script src="/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="/adminlte/bower_components/jquery-ui/jquery-ui.min.js"></script>
    <script src="/adminlte/plugins/iCheck/icheck.min.js"></script>
    <script src="/adminlte/interface.js" type="text/javascript"></script>
    <script type="text/javascript" defer="" src="{{ mix('static/js/all.js') }}"></script>

    @if(isset($canonical))
        <link rel="canonical" href="{{ $canonical }}"/>
    @endif

    <!-- if contactsPage-->
    @if(Route::getCurrentRoute()->alias == 'contacts')
        <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" defer></script>
    @endif
</head>
