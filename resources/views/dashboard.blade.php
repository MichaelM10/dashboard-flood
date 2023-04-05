@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-3">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <h5 class="col-10 mt-1"> {{ __('Bookmarked Sensors') }} </h5>
                        <div class="col-1 mt-1" > 
                            <span class="tt" data-bs-placement="top" title="{{__('List of Saved/Bookmarked sensors')}}">
                                <i class="fa fa-question-circle" style="font-size:16px"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @forelse($bookmarks as $bookmark)
                    <div class="card">
                        <div class="card-header">
                            <h5>{{$bookmark->sensor->sensor_name}}</h5>
                        </div>
                    </div>
                    @empty
                    <div class="text-black-50">{{ __('Bookmark is empty . . .') }}</div>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class ="card-header">
                    <div class="row">
                        <div class="col-10">
                            <h5 class="col-10 mt-1">{{ __('My Sensors')}}</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body text-center">
                    <!-- Sensor List -->
                    @forelse($sensors as $sensor)
                        <div class="card text-start">
                            <!-- Card Header -->
                                <!--  No Card Header  -->
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md">
                                        <h6 class="card-title"> {{ $sensor->sensor_name }} </h6>
                                        <!-- Sensor Id -->
                                        <div class="row gx-0">
                                            <div class="col-sm-2">
                                                <div class="row">
                                                    <div class="col-9">
                                                        <p class="fw-normal card-text">Sensor Id </p>
                                                    </div>
                                                    <div class="col-1">
                                                        <p class="fw-normal card-text"> : </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <p class="fw-light card-text"> {{ $sensor->sensor_id }} </p>
                                            </div>
                                        </div>
                                        
                                        <!-- Sensor Id -->
                                        <div class="row gx-0">
                                            <div class="col-sm-2">
                                                <div class="row">
                                                    <div class="col-9">
                                                        <p class="fw-normal card-text">Visibility </p>
                                                    </div>
                                                    <div class="col-1">
                                                        <p class="fw-normal card-text"> : </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <p class="fw-light card-text"> {{ $sensor->visibility }} </p>
                                            </div>
                                        </div>

                                        <!-- Modify button -->
                                        <button type="button" class="btn btn-outline-secondary mt-5">Modify</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <h5 class="my-1 card-title">Place a Sensor not found Image here</h5>
                        <p class="mb-5 mt-2 card-text text-black-50"> {{ __("You haven't activated any sensors . . .") }} </p>
                    @endforelse
                    <a href="{{ url('/sensor/activation') }}" class="btn btn-primary my-2 mt-4"> {{ __('Activate a new SensorKu') }} </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
