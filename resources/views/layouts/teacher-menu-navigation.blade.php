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
                    <a class="nav-link active" href="{{url('teacher/dashboard')}}" ><i class="fa fa-fw fa-user-circle"></i>Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('teacher/subjects')}}" ><i class="fas fa-fw fa-book"></i>My Subjects</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('teacher/class-assigned')}}" ><i class="fas fa-fw fa-edit"></i>Class Assigned {{Auth::user()->student}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/teacher/profile/'.Auth::user()->id)}}" ><i class="fas fa-fw fa-user"></i>Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/change-password')}}" ><i class="fas fa-fw fa-unlock"></i>Change Password</a>
                </li>
                
            </ul>
        </div>
    </nav>
</div>