<div class="menu-list">
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav flex-column">
                <li class="nav-divider">
                    Menu
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{url('student/dashboard')}}" ><i class="fa fa-fw fa-user-circle"></i>Dashboard</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{url('student/transactions')}}" ><i class="fas fa-fw fa-dollar-sign"></i>Make Payment</a>
                </li> --}}
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{url('student/subjects')}}" ><i class="fas fa-fw fa-book"></i>My Subjects</a>
                </li> --}}
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{url('student/report-card')}}" ><i class="mdi fa-fw mdi-credit-card-multiple"></i>Academic Report</a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/student/profile/'.Auth::user()->id)}}" ><i class="fas fa-fw fa-user"></i>Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/student/subject-offered/')}}" ><i class="fas fa-fw fa-user"></i>Subject Offered</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/change-password')}}" ><i class="fas fa-fw fa-unlock"></i>Change Password</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{url('student/subjects')}}" ><i class="fa fa-fw fa-rocket"></i>Wallet</a>
                </li> --}}
                <li class="nav-item">
                    <form action="{{url('/logout')}}" method="post">
                        {{ csrf_field() }}
                        <button type="submit" class="dropdown-item" href="#"><i class="fas fa-power-off mr-2"></i>
                        Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
</div>