
<div class="container-fluid">
    <div class="row">
        <div class="col md-8">
            <div class="card">
                <div class="card-header bg-dark text-white">Map</div>
                <div class="card-body gx-0 px-0 py-0">
                    <div wire:ignore id='map' style='width: 100%; height: 70vh;'></div>
                </div>
            </div>
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

        const style = "outdoors-v11"
        //light-v10, outdoors-v11, satellite-v9, streets-v11, dark-v10
        map.setStyle(`mapbox://styles/mapbox/${style}`);

        map.addControl(new mapboxgl.NavigationControl());

        console.log("value: ", @this.test);
        
        map.on('click',(e) =>{
            const longitude = e.lngLat.lng
            const lattitude = e.lngLat.lat
            console.log({longitude, lattitude});
        });
    });
</script>
@endpush

@push('pagetitle', 'Dashboard')