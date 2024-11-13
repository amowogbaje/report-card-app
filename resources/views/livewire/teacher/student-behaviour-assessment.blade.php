<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead class="text-left">
                    <th>Behaviour</th>
                    <th>5</th>
                    <th>4</th>
                    <th>3</th>
                    <th>2</th>
                    <th>1</th>
                </thead>
                @foreach($behaviourAssessments as $key => $behaviour)
                    <tr class="text-left">
                        <td>{{$behaviour}}</td>
                        <td>
                            <label class="custom-control custom-radio">
                                <input type="radio" value="5" name="{{$key}}"  class="custom-control-input" wire:model.defer="{{$key}}"><span class="custom-control-label"></span>
                            </label>
                        </td>
                        <td>
                            <label class="custom-control custom-radio">
                                <input type="radio" value="4" name="{{$key}}"  class="custom-control-input" wire:model.defer="{{$key}}"><span class="custom-control-label"></span>
                            </label>
                        </td>
                        <td>
                            <label class="custom-control custom-radio">
                                <input type="radio" value="3" name="{{$key}}"  class="custom-control-input" wire:model.defer="{{$key}}"><span class="custom-control-label"></span>
                            </label>
                        </td>
                        <td>
                            <label class="custom-control custom-radio">
                                <input type="radio" value="2" name="{{$key}}"  class="custom-control-input" wire:model.defer="{{$key}}"><span class="custom-control-label"></span>
                            </label>
                        </td>
                        <td>
                            <label class="custom-control custom-radio">
                                <input type="radio" value="1" name="{{$key}}"  class="custom-control-input" wire:model.defer="{{$key}}"><span class="custom-control-label"></span>
                            </label>
                        </td>
                    </tr>
                    @error($key)
                    <tr>
                        <td colspan="6">
                            {{-- @error('honesty') <span class="text-danger">{{ $message }}</span>@enderror --}}
                            <span class="text-danger">{{ $message }}</span>
                        </td>
                    </tr>
                    @enderror
                @endforeach
                <tr>
                    <td><button wire:click = "store" class="btn btn-success">Save</button></td>
                </tr>
            </table>
        </div>
    </div>
</div>
