<x-admin-layout>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">{{config('app.name')}}</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                            {{-- <li class="breadcrumb-item active" aria-current="page">E-Commerce Dashboard Template</li> --}}
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end pageheader  -->
    <!-- ============================================================== -->
    <div class="ecommerce-widget">
        @if(session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session()->get('success') }}
                    </div>
        @endif
        @if(session()->has('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session()->get('error') }}
                    </div>
        @endif

        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            @foreach ($subjectAndClasses as $subjectAndClass)
            <div class="col-xl-3 col-md-6 mb-4 ">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="fs-1 text-center font-weight-bold text-primary text-uppercase mb-1">
                                    <a class="text-primary link-info" href="{{url('/teacher/class/'.$subjectAndClass->class->id.'/subject/'.$subjectAndClass->subject->id.'/spreadsheet')}}">{{$subjectAndClass->subject->name}}</a>
                                </div>
                                <div class="h6 mb-0 text-center font-weight-bold text-gray-800">
                                    <span class="text-secondary">{{$subjectAndClass->class->shortname}}</span>
                                </div>
                                
                                <div class="h6 my-1 text-center font-weight-bold text-gray-800">
                                    <a class="btn btn-outline border-primary text-primary link-info" href="{{url('/teacher/class/'.$subjectAndClass->class->id.'/subject/'.$subjectAndClass->subject->id.'/spreadsheet')}}">Fill Score Sheet</a>
                                </div>
                                @if(get_current_term()->id == active_term()->id)
                                <div class="h6 my-1 text-center font-weight-bold text-gray-800">
                                    <a class="btn btn-outline border-secondary text-secondary link-info" href="{{url('teacher/subject-registration/class/'.$subjectAndClass->class->id.''.'/subject/'.$subjectAndClass->subject->id)}}">Register Students</a>
                                </div>
                                @endif
                                {{-- <div class="h6 mb-0 font-weight-bold text-gray-800">
                                    <span>{{$noOfSubjects}}</span>
                                </div> --}}
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            
        </div>
    </div>
</x-admin-layout>
