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
                <li class="nav-item ">
                    <a class="nav-link active" href="{{url('admin/dashboard')}}"><i class="fa fa-fw fa-user-circle"></i>Dashboard <span class="badge badge-success">6</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('admin/classes')}}" ><i class="fas fa-fw fa-edit"></i>My Classes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('admin/school/info')}}" ><i class="fas fa-fw fa-graduation-cap"></i>Schoo Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('admin/subjects')}}" ><i class="fas fa-fw fa-book"></i>Subjects</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('admin/teachers')}}" ><i class="fas fa-fw fa-book"></i>Teachers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('admin/students')}}" ><i class="fas fa-fw fa-book"></i>Students</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('admin/subject-allocation')}}" ><i class="fas fa-fw fa-book"></i>Subject Allocation</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('admin/transactions')}}" ><i class="fas fa-fw fa-dollar-sign"></i>Transaction</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('admin/profile')}}" ><i class="fas fa-fw fa-user"></i>My Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/change-password')}}" ><i class="fas fa-fw fa-unlock"></i>Change Password</a>
                </li>
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