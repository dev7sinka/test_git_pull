<header class="header header-sticky mb-4">
    <div class="container-fluid">
        {{--  header left --}}
        @include('layouts.header.header-left') {{--  button close sidebar and nav item --}}

        {{-- header right --}}
        @include('layouts.header.header-rigth')

    </div>

    <div class="header-divider"></div>

    @include('layouts.header.page-title')
</header>
