<div>
    @if($isResultUploaded)
        @if(!$isPercentageCalculated) 
            <button class="btn btn-primary mx-3" wire:click="computeSubjectPercentage">Compute Percentage</button>
        @elseif(!$isResultProcessed)
            <button class="btn btn-primary mx-3" wire:click="process">Process Result</button>
            <button class="btn btn-primary mx-3" wire:click="gradeSubjectScores">Grade Results</button>
        @endif
    @endif
    @if($isResultProcessed)
        <button class="btn btn-primary mx-3" wire:click="gradeSubjectScores">Grade Results</button>
        <button class="btn btn-primary mx-3" wire:click="distributeSubjectPosition">Get Positions</button>
        <span>Average Score: {{$averageScore}}</span>
        <span>| Highest Score: {{$highestScore}}</span>
        <span>| Lowest Score: {{$lowestScore}}</span>
    @endif
</div>
