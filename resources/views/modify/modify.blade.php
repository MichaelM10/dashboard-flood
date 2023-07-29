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
                            <h5 class="col mt-1">{{ __('Sensor Details')}}</h5>
                        </div>
                    </div>
                </div>
                <!-- CARD BODY -->
                <div class="card-body row">
                    <!-- GENERAL FIELD COLUMN -->
                    <div class="col-6">
                        <h6 class="card-subtitle">Sensor Info</h6>
                        <form class="row mt-1 g-3" style="" autocomplete="off" action="{{url('/save-modify')}}" method="post">
                            @csrf
                            <!-- Row 1 -->
                            <div class="row mt-3 pr-0">
                                <div class="col-sm-4" style="width:16vw">
                                    <label for="sensor_id" class="form-label">{{__('SensorKu Code')}}</label>
                                    <input type="number" class="form-control" id="sensor_id" name="sensor_id" value="{{ $sensor->id ?? old('sensor_id') }}" readonly>
                                </div>
                                <div class="col-sm-4" style="width:16vw">
                                    <label for="activation_password" class="form-label">{{__('Activation Password')}}</label>
                                    <input type="text" class="form-control" id="activation_password" name="activation_password" value="{{ $sensor->activation_password ?? old('activation_password') }}" readonly>
                                </div>
                            </div>
    
                            <!-- Row 2 -->
                            <div class="row mt-3">
                                <div class="col-sm-4" style="width:16vw">
                                    <label for="sensor_name" class="form-label">{{__('Station/Sensor Name')}}</label>
                                    <input type="text" class="form-control" id="sensor_name" name="sensor_name" value="{{ $sensor->sensor_name ?? old('sensor_name') }}">
                                </div>
                                <div class="col-sm-4" style="width:16vw">
                                    <label for="visibility" class="form-label">{{__('Public Visibility')}}</label>
                                    <select class="form-select" name="visibility" id="visibility" value=" {{ $sensor->visibility ?? old('visibility') }} " disabled>
                                        <option readonly>Public</option>
                                        <option readonly>Private</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row mt-3 pr-0">
                                <div class="col-sm-4 input-group" style="width:16vw">
                                    <label for="selisih_nol" class="form-label">Selisih Nol</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="selisih_nol" name="selisih_nol" value="{{$sensor->selisih_nol ?? old('selisih_nol')}}">
                                        <span class="input-group-text">cm</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-3 pr-0">
                                <div class="col-sm-4" style="width:32vw">
                                    <label for="description" class="form-label">{{__('Description')}}</label>
                                    <textarea type="textarea" class="form-control" id="description" rows="3" name="description" value="{{ $sensor->description ?? old('description') }}"></textarea>
                                </div>
                            </div>

                            <!-- SAVE BUTTON -->
                            <div class="row mt-5 pr-0">    
                                <div class="col">
                                    <button type="submit" class="btn btn-primary mx-auto shadow" style="width:32vw"> <i class="bi bi-save"></i>{{ __(' Save') }} </button>
                                </div>
                            </div>

                        </form>
                    </div>
                


                    <!-- MAPS COLUMN -->
                    <div class="col-3">
                        <h6 class="card-subtitle">Location</h6>
                        <div class="mt-3 mx-auto border border-2 border-secondary shadow rounded" id="map" style="width: 30vh; height: 30vh"></div>
                    </div>



                    <!-- MAP DETAIL COLUMN -->
                    <div class="col-3">
                        <h6 class="card-subtitle">GPS Details</h6>
                        <div class="row mt-3 pr-0">
                            <form action="{{url('/sensor/change-location')}}" method="POST">
                                @csrf
                                <div class="col-sm-4 visually-hidden" style="width:16vw">
                                    <label for="sensor_id" class="form-label">{{__('SensorKu Code')}}</label>
                                    <input type="number" class="form-control" id="sensor_id" name="sensor_id" value="{{ $sensor->id ?? old('sensor_id') }}" readonly>
                                </div>
                                <div class="col-sm-4 visually-hidden" style="width:16vw">
                                    <label for="sensor_name" class="form-label">{{__('Sensor Name')}}</label>
                                    <input type="string" class="form-control" id="sensor_name" name="sensor_name" value="{{ $sensor->sensor_name ?? old('sensor_name') }}" readonly>
                                </div>
                                <div class="col-sm-4 mb-1" style="width:16vw">
                                    <label for="gps_longitude" class="form-label my-0">{{__('Longitude')}}</label>
                                    <input type="string" style="width:16vw" class="form-control" id="gps_longitude" name="gps_longitude" value="{{ $sensor->gps_longitude ?? $gps_longitude ?? "Not Set" }}" readonly>
                                </div>
                                <div class="col-sm-4 mb-1" style="width:16vw">
                                    <label for="gps_latitude" class="form-label my-0">{{__('Latitude')}}</label>
                                    <input type="string" style="width:16vw" class="form-control" id="gps_latitude" name="gps_latitude" value="{{ $sensor->gps_latitude ?? $gps_latitude ?? "Not Set" }}" readonly>
                                </div>
                                <div class="col mt-4">
                                    <button type="submit" class="btn btn-success mx-auto shadow" style="width:16vw">
                                        <i class="bi bi-geo"></i>{{ __(' Adjust Location') }} 
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
            @isset($success)
                <div class="alert alert-success mt-1" role="alert">
                    {{ $success }}
                </div>
            @endisset
        </div>
    </div>
</div>
@endsection

@push('mapbox')
<script>
    mapboxgl.accessToken = '{{env("MAPBOX_KEY")}}';
    var gps_long = document.getElementById('gps_longitude').value;
    var gps_lat = document.getElementById('gps_latitude').value;
    var sensor_id = document.getElementById('sensor_id').value;
    var getJsonLink = 'https://sensorku.site/api/sensor/geoJsonOne/' + sensor_id;
    var defaultLocation = [117.48878532291059, -2.9365280716009607];

    if(gps_long === 'Not Set'){
    }else{
        defaultLocation = [gps_long, gps_lat];
    }

    var map = new mapboxgl.Map({
        container: 'map',
        center: defaultLocation,
        zoom: 3.7
    });

    const style = "outdoors-v11"
    //light-v10, outdoors-v11, satellite-v9, streets-v11, dark-v10
    map.setStyle(`mapbox://styles/mapbox/${style}`);

    //Enable Nav Buttons
    map.addControl(new mapboxgl.NavigationControl());

    map.on('load', async () => {
        // Get the initial location of the International Space Station (ISS).
        const geoJson = await getLocation();
        // Add the Sensor location as a source.
        map.addSource('sensors', {
            type: 'geojson',
            data: geoJson
        });
        
        //Add circle layer
        map.addLayer({
            'id': 'sensors',
            'type': 'circle',
            'source': 'sensors',
            'paint': {
                'circle-radius': 5,
                'circle-color': ['match',
                                ['get', 'status'],
                                'AMAN',     '#3bb2d0',
                                'WASPADA',  '#fbb03b',
                                'BAHAYA',   '#e55e5e',
                                /* other */ '#ccc'],
                'circle-stroke-width': 1
            },
            'filter': ['==', '$type', 'Point']
        });

        //Add popup
        map.on('click', 'sensors', (e) => {
        // Copy coordinates array.
        const coordinates = e.features[0].geometry.coordinates.slice();
        const sensorName = e.features[0].properties.sensorName;
        const status = e.features[0].properties.status;
        const waterLevel = e.features[0].properties.waterLevel;
        const description = e.features[0].properties.sensorDescription;
        const htmlContent = e.features[0].properties.html;

        // Ensure that if the map is zoomed out such that multiple
        // copies of the feature are visible, the popup appears
        // over the copy being pointed to.
        while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
            coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
        }
        
        new mapboxgl.Popup()
            .setLngLat(coordinates)
            .setHTML(htmlContent)
            .setMaxWidth("800px")
            .addTo(map);
        });

        // Change the cursor to a pointer when the mouse is over the places layer.
        map.on('mouseenter', 'sensors', () => {
            map.getCanvas().style.cursor = 'pointer';
        });
        
        // Change it back to a pointer when it leaves.
        map.on('mouseleave', 'sensors', () => {
            map.getCanvas().style.cursor = '';
        });

        console.log(geoJson.features);

        // Update the source from the API every 10 seconds.
        const updateSource = setInterval(async () => {
            const geoJson = await getLocation(updateSource);
            map.getSource('sensors').setData(geoJson);
        }, 10000);

        async function getLocation(updateSource) {
            // Make a GET request to the API and return the location of the ISS.
            try {
                const response = await fetch(
                    getJsonLink,
                    { method: 'GET' }
                );

                return await response.json();
            } catch (err) {
                // If the updateSource interval is defined, clear the interval to stop updating the source.
                if (updateSource) clearInterval(updateSource);
                throw new Error(err);
            }
        }

        
    });
</script>
<script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>
@endpush