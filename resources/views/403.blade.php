@if(Auth::user()->role == 'student')

    @livewire('student-unauthorized')

@else 
    @livewire('teacher-unauthorized')
@endif