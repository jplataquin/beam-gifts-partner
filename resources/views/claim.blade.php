@extends('layouts.app')

@section('content')

<div class="container">

    <h1>{{$uid}}</h1>
    
    <div class="row justify-content-center">
        <div class="col-md-9 ">
            <div class="card" width="100%">
                <div class="card-header">
                    &nbsp;
                </div>

                <img class="card-img-top" src="{{config('app')['api_base_url']}}storage/photos/item/400px/{{$data->item->photo['400px']}}" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">{{$data->item_name}}</h5>
                    <p>By {{$data->brand_name}}</p>
                    <h3>PHP: {{ number_format($data->price,2) }}
                    <h3>🎁: {{$data->consumed}} / {{$data->quantity}}

                    <div class="row mt-5">
                        <div class="col-6">
                            <button class="btn btn-warning w-100" id="cancelBtn" >Cancel</button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-primary w-100" id="claimBtn" >Claim</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>

<script type="module">
    import {$q} from '/adarna.js';

    (async ()=>{

        const claimBtn = $q('#claimBtn').first();

        claimBtn.onclick = (e)=>{

            let answer = prompt('Type "Yes" if you are sure to release one quantity of these item');

            if(answer.trim() == ''){
                return false;
            }

            if(answer.toUpperCase() != 'YES'){
                alert('Incorrect input, please try again');
                return false;
            }

            if(!confirm('By proceeding with this transaction you understand that once successful it is conisderd irreversible?')){

                return false;
            }

            //Do spinner loader

            window.util.$post('/claim',{
                uid: "{{$uid}}"
            }).then(reply=>{

                alert('DONE');
                
                console.log(reply);
            });
        }

    })();
</script>
@endsection