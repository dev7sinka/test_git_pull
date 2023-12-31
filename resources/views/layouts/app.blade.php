<!DOCTYPE html>
<html lang="en">

<head>
    <base href="./">
    <meta charset="utf-8">
    @include('layouts.partials.css')
</head>

<body>

    {{-- sidebar --}}
    <div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
        @include('layouts.sidebar.logo-sidebar')
        @include('layouts.sidebar.sidebar')
    </div>
    {{-- end sidebar --}}

    <div class="wrapper d-flex flex-column min-vh-100 bg-light">

        {{-- header --}}
        @include('layouts.header.header')

        <div class="body flex-grow-1 px-3">
            <div class="bg-white shadow-sm rounded p-3">

                {{-- content --}}
                @yield('content')

            </div>
        </div>
        {{-- footer --}}
        @include('layouts.footer.footer')

    </div>

    {{-- js --}}
    @include('layouts.partials.js')
</body>

</html>
