@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card mt-5">
                <div class ="card-header">
                    <div class="row">
                        <div class="col-10">
                            <h5 class="col-10 mt-1">{{ __('SensorKu Activation')}}</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form class="row g-3" autocomplete="off" action="{{url('/activate-a-sensorku')}}">
                        <div class="col-sm-5 mx-auto">
                            <label for="sensor_id" class="form-label">{{__('SensorKu Code')}}</label>
                            <input type="text" class="form-control" id="sensor_id" name="sensor_id" placeholder="SEN-F-XYZ . . ." autocomplete="chrome-off" value="{{ old('sensor_id') }}">
                        </div>
                        <div class="col-sm-5 mx-auto">
                            <label for="activation_password" class="form-label">{{__('Activation Password')}}</label>
                            <input type="text" class="form-control" id="activation_password" name="activation_password" autocomplete="chrome-off" value="{{ old('activation_password') }}">
                        </div>
                        <div class="row">
                            <button type="submit" class="btn btn-primary mt-3 col-sm-3 mx-auto">Activate</button>
                        </div>
                    </form>
                    <!-- <p class="mx-auto mt-5 col-sm-4 mt-1 card-text text-black-50 text-center"> {{ __("[ ? ] Use this page only to activate SensorKu sensors. To setup your own sensor, please go to the .... page") }} </p> -->

                </div>    
            </div>
            @if (\Session::has('error'))
                    <div class="alert alert-warning mt-5" role="alert">
                        {{ \Session::get('error') }}
                    </div>
            @endif
            @if (\Session::has('success'))
                    <div class="alert alert-success mt-5" role="alert">
                        {{ \Session::get('success') }}
                    </div>
            @endif
        </div>
    </div>
</div>
@endsection
