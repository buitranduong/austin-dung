@extends('layouts.theme')

@section('content')
    @if(!empty($sim_data))
        <x-theme.section.form-order :$mobile :$phone :$sim_data/>
    @else
        <x-theme.section.sim-sold :$mobile :$sim :data="$sim_same" />
    @endif
@endsection
