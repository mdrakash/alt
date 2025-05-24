@extends('app')
@section('child')
    <service-create :partses="{{json_encode($partses)}}"></service-create>
@endsection