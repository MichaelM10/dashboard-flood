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
                    <form class="row g-3" action="{{url('/activate-a-sensorku')}}">
                        <div class="col-sm-5 mx-auto text-center">
                            <label for="sensor_id" class="form-label">{{__('SensorKu Code')}}</label>
                            <input type="text" class="form-control" id="sensor_id" name="sensor_id" placeholder="SEN-X-XXXX...">
                        </div>
                        <div class="row">
                            <button type="submit" class="btn btn-primary mt-3 col-sm-3 mx-auto">Activate</button>
                        </div>
                    </form>
                </div>    
            </div>
            @if (\Session::has('error'))
                    <!-- <div class="alert alert-error">
                        <ul>
                            <li>{!! \Session::get('error') !!}</li>
                        </ul>
                    </div> -->
                    <div class="alert alert-warning mt-5" role="alert">
                        {{ \Session::get('error') }}
                    </div>
            @endif
        </div>
    </div>
</div>
@endsection
