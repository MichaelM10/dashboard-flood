@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-7">
            <div class="card mt-5">
                <div class="card-header">
                    <div class="row">
                        <div class="col-10">
                            <h5 class="col-10 mt-1">{{ __('Modify a SensorKu')}}</h5>
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
                                <input type="number" class="form-control" id="sensor_id" name="sensor_id" value="{{ old('sensor_id') }}" readonly>
                            </div>
                            <div class="col-sm-4">
                                <label for="activation_password" class="form-label">{{__('Activation Password')}}</label>
                                <input type="text" class="form-control" id="activation_password" name="activation_password" value="{{ old('activation_password') }}" readonly>
                            </div>
                        </div>

                        <!-- Row 2 -->
                        <div class="row mt-3 justify-content-center">
                            <div class="col-sm-4">
                                <label for="sensor_name" class="form-label">{{__('Sensor Name')}}</label>
                                <input type="text" class="form-control" id="sensor_name" name="sensor_name" value="{{ old('sensor_name') }}">
                            </div>
                            <div class="col-sm-4">
                                <label for="visibility" class="form-label">{{__('Public Visibility')}}</label>
                                <select class="form-select" name="visibility" id="visibility" value=" {{ old('visibility') }} ">
                                    <option>Public</option>
                                    <option>Private</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3 justify-content-center">
                            <div class="col-sm-4">
                                <label for="selisih_nol" class="form-label">Selisih Nol</label>
                                <input type="number" class="form-control" id="selisih_nol" name="selisih_nol" value="{{$sensor->selisih_nol}}">
                            </div>
                        </div>

                        <div class="row">
                            <button type="submit" class="btn btn-primary mt-3 col-sm-3 mx-auto"> {{ __('Save') }} </button>
                        </div>
                    </form>
                    <!-- <p class="mx-auto mt-5 col-sm-4 mt-1 card-text text-black-50 text-center"> {{ __("[ ? ] Use this page only to activate SensorKu sensors. To setup your own sensor, please go to the .... page") }} </p> -->
                    @isset($success)
                        <div class="alert alert-success mt-5" role="alert">
                            {{ $success }}
                        </div>
                    @endisset
                </div>    
            </div>
        </div>
    </div>
</div>
@endsection
