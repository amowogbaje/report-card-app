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
    <div class="row">
        {{-- <div class="col-md-6">
            @livewire('payment.payment-details', ['number' => 10])
        </div>
        <div class="col-md-6">
            @livewire('payment.payment-transactions', ['number' => 10])
        </div> --}}
        <div class="col-sm-12 mx-auto">
            @livewire('payment.student-payment-sheet')
        </div>
    </div>
    
</x-admin-layout>