<div>
    @if($isResultUploaded)
        @if(!$isResultProcessed) 
            <button class="btn btn-primary mx-3" style="vertical-align:middle" wire:click="processAtOnce"> <div wire:loading><span class="dashboard-spinner spinner-xs"></span></div>Process Results</button>
        {{-- @elseif(!$isResultProcessed)
            <button class="btn btn-primary mx-3" wire:click="process">Process Result</button>
            <button class="btn btn-primary mx-3" wire:click="gradeSubjectScores">Grade Results</button> --}}
        @endif
    @endif
    @if($isResultProcessed)
        {{-- <button class="btn btn-primary mx-3" wire:click="gradeSubjectScores">Grade Results</button>
        <button class="btn btn-primary mx-3" wire:click="distributeSubjectPosition">Get Positions</button> --}}
        <span>Average Score: {{$averageScore}}</span>
        <span>| Highest Score: {{$highestScore}}</span>
        @if(!$zeroExistInLowestScore)
        <span>| Lowest Score: {{$lowestScore}}</span>
        @else
        <span>Lowest Score: not ready</span>
        @endif
    @endif
</div>
