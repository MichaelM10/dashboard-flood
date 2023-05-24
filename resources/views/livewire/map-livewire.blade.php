
<div class="container-fluid">
    <div class="row">
        <div class="col md-8">
            <div class="card">
                <div class="card-header bg-dark text-white">Map</div>
                <div class="card-body gx-0 px-0 py-0">
                    <div wire:ignore id='map' style='width: 100%; height: 70vh;'></div>
                </div>
            </div>
            <button wire:click="$emitSelf('refresh')" class="btn btn-primary w-100 mt-3">
                Refresh
            </button>
        </div>
        <div class="col-md-4">
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
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:load', () => {
        const defaultLocation = [117.48878532291059, -2.9365280716009607];
        mapboxgl.accessToken = '{{env("MAPBOX_KEY")}}';
        var map = new mapboxgl.Map({
            container: 'map',
            center: defaultLocation,
            zoom: 3.7
        });

        const loadLocations = (geoJson) => {
            console.log({geoJson});
            geoJson.features.forEach((sensor) => {
                const {geometry, properties} = sensor;
                const {sensorId, sensorName, status, sensorDescription, waterLevel} = properties

                let markerElement = document.createElement('div')
                markerElement.className = 'marker' + sensorId
                markerElement.id = sensorId
                markerElement.style.backgroundImage = 'url(https://docs.mapbox.com/help/demos/custom-markers-gl-js/mapbox-icon.png)'
                markerElement.style.backgroundSize = 'cover'
                markerElement.style.width = '50px'
                markerElement.style.height = '50px'

                const content = `
                <div style="overflow-y, auto; max-height:400px, width:100%">
                    <table class="table table-sm mt-2">
                        <tbody>
                            <tr>
                                <td>Title</td>
                                <td>${sensorName}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>${status}</td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>${sensorDescription}</td>
                            </tr>
                            <tr>
                                <td>Water Level</td>
                                <td>${waterLevel}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                `

                const popUp = new mapboxgl.Popup({
                    offset:25
                }).setHTML(content).setMaxWidth("400px")

                new mapboxgl.Marker(markerElement)
                .setLngLat(geometry.coordinates)
                .setPopup(popUp)
                .addTo(map)
                
                

            })
        }

        loadLocations({!! $geoJson !!})

        const style = "outdoors-v11"
        //light-v10, outdoors-v11, satellite-v9, streets-v11, dark-v10
        map.setStyle(`mapbox://styles/mapbox/${style}`);

        map.addControl(new mapboxgl.NavigationControl());
        
        map.on('click',(e) =>{
            const longitude = e.lngLat.lng
            const lattitude = e.lngLat.lat
            console.log({longitude, lattitude});
        });
    });
</script>
@endpush

@push('pagetitle', 'Dashboard')