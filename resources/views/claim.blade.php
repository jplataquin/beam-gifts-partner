@extends('layouts.app')

@section('content')

<div class="container">

    <h1>{{$uid}}</h1>
    
    <div class="row">
        <div class="col-12 text-center">
            <img width="400px" src="{{config('app')['api_base_url']}}storage/photos/item/400px/{{$data->item->photo['400px']}}"/>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12 text-center">
            <h2>{{$data->item_name}}</h2>
            <h3>By</h3>
            <h3>{{$data->brand_name}}</h3>
        </div>
    </div>

    <div class="row">
        <h3>PHP: {{ number_format($data->price,2) }}
    </div>


</div>

@endsection