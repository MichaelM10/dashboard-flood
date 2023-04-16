@extends('layouts.app')
@section('content')
<div>
<div wire-ignore id='map' style='width: 400px; height: 300px;'></div>
</div>
@endsection
@push('scripts')
<script>
  mapboxgl.accessToken = '{{env("MAPBOX_KEY")}}';
  var map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11'
  });
</script>

@endpush
