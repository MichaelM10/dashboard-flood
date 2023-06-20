@extends('layouts.app')

@section('title', 'Sensor Detail')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card mt-5">
                <!-- CARD HEADER -->
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h5 class="col mt-1"> {{ $sensor_name }} </h5>
                            <h6> {{ __('Change Location')}} </h4>
                        </div>
                    </div>
                </div>
                <!-- CARD BODY -->
                <div class="card-body row">
                    <!-- MAP DETAIL COLUMN -->
                    <div class="col-3">
                        <h6 class="card-subtitle">Old coordinates</h6>
                        <div class="row mt-3 pr-0">
                                <div class="col-sm-4 mb-1 visually-hidden" style="width:16vw" readonly>
                                    <label for="sensor_id" class="form-label my-0">{{__('Sensor Id')}}</label>
                                    <input type="string" style="width:16vw" class="form-control" id="sensor_id" name="sensor_id" value="{{ $sensor_id }}" readonly>
                                </div>
                                <div class="col-sm-4 mb-1" style="width:16vw">
                                    <label for="old_longitude" class="form-label my-0">{{__('Longitude')}}</label>
                                    <input type="string" style="width:16vw" class="form-control" id="old_longitude" name="old_longitude" value="{{ $sensor->gps_longitude ?? $gps_longitude }}" readonly>
                                </div>
                                <div class="col-sm-4 mb-1" style="width:16vw">
                                    <label for="old_latitude" class="form-label my-0">{{__('Latitude')}}</label>
                                    <input type="string" style="width:16vw" class="form-control" id="old_latitude" name="old_latitude" value="{{ $sensor->gps_latitude ?? $gps_latitude }}" readonly>
                                </div>
                        </div>
                    </div>

                    <!-- MAPS COLUMN -->
                    <div class="col-5">
                        <h6 class="card-subtitle">Map View</h6>
                        <div class="mt-3 mx-auto border border-2 border-secondary shadow rounded" id="map" style="width: 50vh; height: 50vh"></div>
                    </div>
                    
                    <!-- NEW COORD COLUMN -->
                    <div class="col-3">
                        <h6 class="card-subtitle">New coordinates</h6>
                        <div class="row mt-3 pr-0">
                            <form action="/sensor/save-new-location" method="POST">
                                @csrf
                                <div class="col-sm-4 mb-1" style="width:16vw" hidden readonly>
                                    <label for="sensor_id" class="form-label my-0">{{__('Sensor Id')}}</label>
                                    <input type="string" style="width:16vw" class="form-control" id="sensor_id" name="sensor_id" value="{{ $sensor_id }}" readonly>
                                </div>
                                <div class="col-sm-4 mb-1" style="width:16vw" hidden readonly>
                                    <label for="sensor_name" class="form-label my-0">{{__('Sensor Id')}}</label>
                                    <input type="string" style="width:16vw" class="form-control" id="sensor_name" name="sensor_name" value="{{ $sensor_name }}" readonly>
                                </div>
                                {{-- Old Locations --}}
                                <div class="col-sm-4 mb-1" style="width:16vw" hidden>
                                    <label for="old_longitude" class="form-label my-0">{{__('Longitude')}}</label>
                                    <input type="string" style="width:16vw" class="form-control" id="old_longitude" name="old_longitude" value="{{ $sensor->gps_longitude ?? $gps_longitude }}" readonly>
                                </div>
                                <div class="col-sm-4 mb-1" style="width:16vw" hidden>
                                    <label for="old_latitude" class="form-label my-0">{{__('Latitude')}}</label>
                                    <input type="string" style="width:16vw" class="form-control" id="old_latitude" name="old_latitude" value="{{ $sensor->gps_latitude ?? $gps_latitude }}" readonly>
                                </div>
                                {{-- New Locations --}}
                                <div class="col-sm-4 mb-1" style="width:16vw">
                                    <label for="new_longitude" class="form-label my-0">{{__('New Longitude')}}</label>
                                    <input type="string" style="width:16vw" class="form-control" id="new_longitude" name="new_longitude" value="" readonly>
                                </div>
                                <div class="col-sm-4 mb-1" style="width:16vw">
                                    <label for="new_latitude" class="form-label my-0">{{__('New Latitude')}}</label>
                                    <input type="string" style="width:16vw" class="form-control" id="new_latitude" name="new_latitude" value="" readonly>
                                </div>
                                <div class="col mt-4">
                                    <button type="submit" class="btn btn-success mx-auto shadow" data-bs-toggle="modal" data-bs-target="#staticBackdropMap" style="width:16vw">
                                        <i class="bi bi-geo"></i>{{ __(' Confirm Change') }} 
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <!-- END OF CARD BODY -->
            </div>
            <!-- END OF CARD -->
            <!-- Notifications -->
            
            @isset($message)
                <div class="alert alert-primary mt-1" role="alert">
                    {{ $message }}
                </div>
            @endisset
            @if (\Session::has('success'))
                <div class="alert alert-success mt-5" role="alert">
                    {{ \Session::get('success') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('mapbox')
<script>
    mapboxgl.accessToken = '{{env("MAPBOX_KEY")}}';
    var gps_long = document.getElementById('old_longitude').value;
    var gps_lat = document.getElementById('old_latitude').value;
    var sensor_id = document.getElementById('sensor_id').value;
    var getJsonLink = 'https://sensorku.site/api/sensor/geoJsonOne/' + sensor_id;

    const defaultLocation = [gps_long, gps_lat];
    // const defaultLocation = [117.48878532291059, -2.9365280716009607];

    var map = new mapboxgl.Map({
        container: 'map',
        center: defaultLocation,
        zoom: 3.7
    });

    const marker1 = new mapboxgl.Marker({
        color:"#2E86C1"
    })
    .setLngLat([gps_long, gps_lat])
    .addTo(map);

    var marker = new mapboxgl.Marker({
        color: "#A4A4A4",
        draggable: true
    });

    function add_marker (event) {
        var coordinates = event.lngLat;

        const longitude = coordinates.lng;
        const latitude = coordinates.lat;
        document.getElementById('new_longitude').value = longitude;
        document.getElementById('new_latitude').value = latitude;

        marker.setLngLat(coordinates).addTo(map);
    }
    map.on('click', add_marker);

    function onDragEnd() {
        const lngLat = marker.getLngLat();
        document.getElementById('new_longitude').value = lngLat.lng;
        document.getElementById('new_latitude').value = lngLat.lat;
    }
    marker.on('dragend', onDragEnd);


    const style = "outdoors-v11"
    //light-v10, outdoors-v11, satellite-v9, streets-v11, dark-v10
    map.setStyle(`mapbox://styles/mapbox/${style}`);

    //Enable Nav Buttons
    map.addControl(new mapboxgl.NavigationControl());
    
</script>
<script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>
@endpush