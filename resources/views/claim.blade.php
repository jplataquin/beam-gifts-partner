@extends('layouts.app')

@section('content')

<div class="container">

    <h1>{{$uid}}</h1>
    
    <div class="row">
        <div class="col-md-9 text-center">
            <div class="card" width="100%">
                <div class="card-header">
                    &nbsp;
                </div>

                <img class="card-img-top" src="{{config('app')['api_base_url']}}storage/photos/item/400px/{{$data->item->photo['400px']}}" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">{{$data->item_name}}</h5>
                    <p>By {{$data->brand_name}}</p>
                    <h3>PHP: {{ number_format($data->price,2) }}
                </div>
            </div>
        </div>
    </div>



</div>

@endsection