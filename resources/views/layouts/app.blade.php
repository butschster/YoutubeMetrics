<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {!! $meta !!}
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css"
          integrity="sha384-3AB7yXWz4OeoZcPbieVW64vVXEwADiYyAEhwilzWsLw+9FgqpyjjStpPnpBO8o8S" crossorigin="anonymous">

    <script>
        window.app = {!!
            json_encode([
                'user' => auth()->user(),
                'permissions' => [
                    'channel' => [
                        'report' => Gate::allows('report', new \App\Entities\Channel()),
                        'moderate' => Gate::allows('moderate', new \App\Entities\Channel())
                    ]
                ]
            ])!!};
    </script>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'Laravel') }}">
            </a>

            @include('layouts._partials.navbar')
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    @include('layouts._partials.footer')
</div>

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-115897021-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());
    gtag('config', 'UA-115897021-1');
</script>
@stack('scripts')
</body>
</html>
