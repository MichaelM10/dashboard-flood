<div class="container">
    <div class="row mt-5">
        <h1 class="fs-5 text-center">Sensor Fields</h1>
    </div>
    <div class="row justify-content-center">
        <div class="w-50">
            <div class="card my-3">
                <!-- Card Body -->
                <div class="card-body">
                    <form class="row g-3 justify-content-center">
                        <div class="col-4">
                            <label class="visually-hidden">Field Name</label>
                            <input type="text" class="form-control" wire:model="field_name.0" placeholder="Field Name">
                            @error('field_name.0') <span class="text-danger error">{{$message}}</span>@enderror
                        </div>
                        <div class="col-6">
                            <label class="visually-hidden">Field Name</label>
                            <textarea class="form-control" wire:model="field_description.0" name="" id="" cols="30" rows="10"></textarea>
                            @error('field_description.0') <span class="text-danger error">{{$message}}</span>@enderror
                        </div>
                        <div class="col-2">
                            <button class="btn btn-primary mb-3" wire:click.prevent="add({{$i}})"><i class="bi bi-plus"></i></button>
                        </div>


                        <!-- Additional field -->
                        @foreach($inputs as $key => $value)
                        <div class="col-4">
                            <label class="visually-hidden">Field Name</label>
                            <input type="text" class="form-control" wire:model="field_name.{{$value}}" placeholder="Field Name">
                            @error('username.') <span class="text-danger error">{{$message}}</span>@enderror
                        </div>
                        <div class="col-6">
                            <label class="visually-hidden">Field Name</label>
                            <textarea class="form-control" wire:model="" name="" id="" cols="30" rows="10"></textarea>
                            @error('username.') <span class="text-danger error">{{$message}}</span>@enderror
                        </div>
                        <div class="col-2">
                            <button class="btn btn-secondary mb-3" wire:click.prevent="remove({{$key}})"><i class="bi bi-x"></i></button>
                        </div>
                        @endforeach
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn-primary" wire:click.prevent="store()">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- End of Card Body -->
            </div>
            @if (session()->has('message'))
                <div class="alert alert-success">
                {{ session('message') }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('pagetitle', 'Sensor')