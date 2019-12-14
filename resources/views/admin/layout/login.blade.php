<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Basil: Hotel - Admin</title>

    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">

</head>
<body>
    <div class='container mt-4'>
        <div class='row mt-4'>
            <div class='ml-auto mr-auto col-10 col-md-6 col-xl-4 mt-5'>
                <div class='card'>
                    <img src="{{ asset('images/login.jpg') }}" class="card-img-top">
                    <div class='card-body'>
                        <div class='text-center my-4'>
                            <img src='{{ asset('images/logo-blue.png') }}' height='50'>
                        </div>

                        @alerts()
                        @stack('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ mix('/js/app.js') }}" ></script>
    
</body>
</html>
