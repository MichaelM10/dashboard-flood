@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row w-75">
        <div class="col md-8">
            <div class="card">
                <div class="card-header bg-dark text-white"><i class="bi bi-map"></i> Map</div>
                <div class="card-body gx-0 px-0 py-0">
                    <div id='map' style='width: 100%; height: 70vh;'></div>
                </div>
            </div>
        </div>
        <!-- <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-dark text-white">Filter</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</div>
@endsection

@push('mapbox')
<script>
    mapboxgl.accessToken = '{{env("MAPBOX_KEY")}}';
    const defaultLocation = [117.48878532291059, -2.9365280716009607];
    var map = new mapboxgl.Map({
        container: 'map',
        center: defaultLocation,
        zoom: 3.7
    });
    const style = "outdoors-v11"
    //light-v10, outdoors-v11, satellite-v9, streets-v11, dark-v10
    map.setStyle(`mapbox://styles/mapbox/${style}`);
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
            .setOffset(10)
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
                    'https://sensorku.site/api/sensor/geoJson',
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