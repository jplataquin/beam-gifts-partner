@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-9 ">
            <div class="card" width="100%">
                <div class="card-header">
                    &nbsp;
                </div>

                <img class="card-img-top" src="{{config('app')['api_base_url']}}storage/photos/item/400px/{{$data->item->photo['400px']}}" alt="Card image cap">
                <div class="card-body">
                    <h1>{{$status}}</h1>
                    <h5 class="card-title">{{$data->item_name}}</h5>
                    <p>By {{$data->brand_name}}</p>
                    <h3>PHP: {{ number_format($data->price,2) }}
                    <h3>Expires at: {{ $data->expires_at->format('M d, Y - h:i:s') }}</h3>
                    <h3>🎁: {{$data->consumed}} / {{$data->quantity}}
                    
                    @if($data->consumed >= $data->quantity)
                        <div class="text-center bg-info mt-3">
                            <h1>Fully Claimed</h1>
                        </div>
                    
                    @else
                        <div class="row mt-5">
                            <div class="col-6">
                                <button class="btn btn-warning w-100" id="cancelBtn" >Cancel</button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-primary w-100" id="claimBtn" >Claim</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>



</div>

<script type="module">
    import {$q} from '/adarna.js';

    (async ()=>{

        const claimBtn  = $q('#claimBtn').first();
        const cancelBtn = $q('#cancelBtn').first();

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
            window.FreezeUI();

            window.util.$post('/claim',{
                uid: "{{$uid}}",
                screen_h: window.outerHeight,
                screen_w: window.outerWidth,
                d_uid: window.util.getMachineId()
            }).then(reply=>{

                window.UnFreezeUI();

                if(reply.status <= 0){
                    
                    alert(reply.message);
                    return false;
                }

                window.util.toastCenter('Item claimed successfully');
                
                setTimeout(()=>{
                    document.location.reload();
                },2000);

            }).catch((e)=>{
                console.log(e);
                alert('Something went wrong');
                window.UnFreezeUI();
            });
        }

        cancelBtn.onclick = (e)=>{
            document.location.href = '/';
        }
    })();
</script>
@endsection