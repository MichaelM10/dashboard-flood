@extends('layouts.app')

@section('title', 'Sensor Detail')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-7">
            <div class="card mt-5">
                <div class="card-header">
                    <div class="row">
                        <div class="col-10">
                            <h5 class="col-10 mt-1">{{ __('Sensor Details')}}</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form class="row g-3" autocomplete="off" action="{{url('/save-modify')}}" method="post">
                        @csrf
                        <!-- Row 1 -->
                        <div class="row mt-3 justify-content-center">
                            <div class="col-sm-4">
                                <label for="sensor_id" class="form-label">{{__('SensorKu Code')}}</label>
                                <input type="number" class="form-control" id="sensor_id" name="sensor_id" value="{{ $sensor->id }}" readonly>
                            </div>
                            <div class="col-sm-4">
                                <label for="activation_password" class="form-label">{{__('Activation Password')}}</label>
                                <input type="text" class="form-control" id="activation_password" name="activation_password" value="{{ $sensor->activation_password }}" readonly>
                            </div>
                        </div>

                        <!-- Row 2 -->
                        <div class="row mt-3 justify-content-center">
                            <div class="col-sm-4">
                                <label for="sensor_name" class="form-label">{{__('Sensor Name')}}</label>
                                <input type="text" class="form-control" id="sensor_name" name="sensor_name" value="{{ $sensor->sensor_name }}">
                            </div>
                            <div class="col-sm-4">
                                <label for="visibility" class="form-label">{{__('Public Visibility')}}</label>
                                <select class="form-select" name="visibility" id="visibility" value=" {{ $sensor->visibility }} ">
                                    <option>Public</option>
                                    <option>Private</option>
                                </select>
                            </div>
                        </div>

                        
                        <div class="row">
                            <button type="submit" class="btn btn-primary mt-3 col-sm-3 mx-auto"> {{ __('Save') }} </button>
                        </div>
                    </form>
                    <!-- <p class="mx-auto mt-5 col-sm-4 mt-1 card-text text-black-50 text-center"> {{ __("[ ? ] Use this page only to activate SensorKu sensors. To setup your own sensor, please go to the .... page") }} </p> -->
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
    </div>
</div>
@endsection
