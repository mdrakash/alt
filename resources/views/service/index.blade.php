@extends('app')
@section('child')
    <service-index :services="{{json_encode($services)}}"></service-index>
@endsection