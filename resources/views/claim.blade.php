@extends('layouts.app')

@section('content')

<div class="container">

    <h1>{{$uid}}</h1>
    
    <div class="row">
        <div class="col-12 text-center">
            <img src="{{config('app')['api_base_url']}}storage/photos/item/400px/{{$data->photo['400px']}}"/>
        </div>
    </div>

</div>

@endsection