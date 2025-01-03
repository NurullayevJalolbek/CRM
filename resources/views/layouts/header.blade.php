<div class="header">

    <div class="header-left">
        <a href="{{ route('dashboard') }}" class="logo">
            <img src="/assets/img/logo.png" alt="Logo">
        </a>
        <a href="{{ route('dashboard') }}" class="logo logo-small">
            <img src="/assets/img/logo-small.png" alt="Logo" width="30" height="30">
        </a>
    </div>
    <div class="menu-toggle">
        <a href="javascript:void(0);" id="toggle_btn">
            <svg xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                <path
                    d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z" />
            </svg>
        </a>
    </div>

    <div class="top-nav-search">
        <form action="{{ route('students.search') }}" method="GET">
            <input type="text" class="form-control" placeholder="Search here"
                value="{{ Request::get('name_query') }}" name="name_query">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>

    <a class="mobile_btn" id="mobile_btn" style="margin-top: 18px !important">
        <i class="fas fa-bars"></i>
    </a>


    <ul class="nav user-menu">




        <li class="nav-item zoom-screen me-2">
            <a href="#" class="nav-link header-nav-list win-maximize">
                <img src="/assets/img/icons/header-icon-04.svg" alt="">
            </a>
        </li>

        <li class="nav-item dropdown has-arrow new-user-menus">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <span class="user-img">
                    <img class="rounded-circle"
                        src="{{ $user->image ? asset('storage/' . $user->image) : asset('/assets/img/profiles/avatar-02.png') }}"
                        width="31" alt="Soeng Souy">
                    <div class="user-text">
                        <h6>{{ $user->name }}</h6>
                        @foreach ($user->roles as $role)
                            <p class="text-muted mb-0">{{ $role->name }}</p>
                        @endforeach
                    </div>
                </span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('user.edit') }}">Settings</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <div>
                        <button class="dropdown-item has-icon text-danger "> <i
                                class="fas fa-sign-out-alt">Chiqish</i></button>
                    </div>
                </form>
            </div>
        </li>

    </ul>

</div>
