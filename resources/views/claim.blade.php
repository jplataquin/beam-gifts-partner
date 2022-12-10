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
            <h4>By</h4>
            <h4>{{$data->brand_name}}</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-12 text-center">
            <h3>PHP: {{ number_format($data->price,2) }}
        </div>
    </div>


</div>

@endsection