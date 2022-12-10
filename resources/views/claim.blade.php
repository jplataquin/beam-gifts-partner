@extends('layouts.app')

@section('content')

<div class="container">

    <h1>{{$uid}}</h1>
    
    <div class="row">
        <div class="col-12 text-center">
            <img width="400px" src="{{config('app')['api_base_url']}}storage/photos/item/400px/{{$data->item->photo['400px']}}"/>
        </div>
        <div class="col-12 text-center">
            <h3>{{$data->name}}</h3>
        </div>
    </div>

</div>

@endsection