@extends('app')
@section('child')
    <service-index :services="{{json_encode($services)}}" :partses="{{json_encode($partses)}}"></service-index>
@endsection