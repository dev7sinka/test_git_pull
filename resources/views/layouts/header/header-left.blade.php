<button class="header-toggler px-md-0 me-md-3" type="button"
    onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
    <svg class="icon icon-lg">
        <use href="{{ asset('assets/vendors/@coreui/icons/svg/free.svg#cil-menu') }}"></use>
    </svg>
</button><a class="header-brand d-md-none" href="#">
    <svg width="118" height="46" alt="CoreUI Logo">
        <use href="{{ asset('assets/assets/brand/coreui.svg#full') }}"></use>
    </svg></a>
<ul class="header-nav d-none d-md-flex">
    <li class="nav-item"><a class="nav-link" href="#">Dashboard</a></li>
    <li class="nav-item"><a class="nav-link" href="#">Users</a></li>
    <li class="nav-item"><a class="nav-link" href="#">Settings</a></li>
</ul>
<ul class="header-nav ms-auto">
    <li class="nav-item"><a class="nav-link" href="#">
            <svg class="icon icon-lg">
                <use href="{{ asset('assets/vendors/@coreui/icons/svg/free.svg#cil-bell') }}"></use>
            </svg></a></li>
    <li class="nav-item"><a class="nav-link" href="#">
            <svg class="icon icon-lg">
                <use href="{{ asset('assets/vendors/@coreui/icons/svg/free.svg#cil-list-rich') }}"></use>
            </svg></a></li>
    <li class="nav-item"><a class="nav-link" href="#">
            <svg class="icon icon-lg">
                <use href="{{ asset('assets/vendors/@coreui/icons/svg/free.svg#cil-envelope-open') }}"></use>
            </svg></a></li>
</ul>
