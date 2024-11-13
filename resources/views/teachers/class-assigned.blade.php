<x-admin-layout>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">{{config('app.name')}}</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard </a></li>
                            {{-- <li class="breadcrumb-item active" aria-current="page">E-Commerce Dashboard Template</li> --}}
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    @if($class_teacher_id == 'no-class-assigned')
    <div class="col-xl-3 col-md-6 mb-4 ">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="h6 mb-0 text-center font-weight-bold text-gray-800">
                            <span class="text-secondary">You are not assigned to a class</span>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    @else
        @livewire('student.student-list', ['number' => 150, 'class_teacher_id' => $class_teacher_id])
    @endif
    
</x-admin-layout>