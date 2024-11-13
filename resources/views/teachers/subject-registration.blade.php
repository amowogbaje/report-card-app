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

        @livewire('teacher.subject-registration', ['class_id' => $class_id, 'subject_id' => $subject_id])
    </div>
    @push('js')
    <script>
        function selectUnselect()
        {
          var checkbox = document.getElementById('select-unselect')
          if (checkbox.checked != true)
          {
              $('#select-unselect-text').text('Select All')
            $(".select-subjects-group").attr("checked", false)
          }
          if (checkbox.checked == true)
          {
              $('#select-unselect-text').text('UnSelect All')
            $(".select-subjects-group").attr("checked", true)
          }
          
        }
    </script>
    @endpush
</x-admin-layout>
