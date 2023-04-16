@extends('layouts.app')
@section('content')
<div>
<div id='map' style='width: 400px; height: 300px;'></div>
</div>
@endsection
@push('scripts')
<div id='map' style='width: 400px; height: 300px;'></div>
<script>
  mapboxgl.accessToken = 'pk.eyJ1Ijoic2hhcmRzaXgiLCJhIjoiY2xnZzdtMHNtMDk2NDNrcnZwbGFqMGU3NSJ9.t4ixFUVLrcygdu0ZvC3a4Q';
  var map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11'
  });
</script>

@endpush
