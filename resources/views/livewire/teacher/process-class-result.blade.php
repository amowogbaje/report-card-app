<div>
    @if($noOfResults !=0) 
        @if($allSubjectsInClassIsProcessed)
        <button class="btn btn-primary mx-3" wire:click="process">Process Class Result </button>
        @elseif(!$allSubjectsInClassIsProcessed) 
        <button class="btn btn-primary mx-3">Waiting for all subjects to be processed</button>
        @endif
    @endif
   

</div>
