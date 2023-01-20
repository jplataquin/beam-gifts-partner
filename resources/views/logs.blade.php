@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Logs</h1>
    <hr>

    <div class="list"></div>
    <div class="text-center">
        <button id="showMoreBtn" class="btn btn-primary btn-block">Show More</button>
    </div>
</div>

<script type="module">
    import {Template,$q} from '/adarna.js';

    const showMoreBtn   = $q('#showMoreBtn').first();
    const t             = new Template();
    //(async () => {

        let page = 1;

        function getList(){
            
            window.FreezeUI();

            window.util.$get('/api/log/list',params).then(reply=>{

                window.UnFreezeUI();

                if(!reply.status){
                    alert(reply.message);
                    return false;
                }
                
                if(!reply.data.items.length){
                    showMoreBtn.style.display = 'none';
                }

                console.log(reply.data);


            });
        }


        showMoreBtn.onclick = (e)=>{
            
            getList();
        }
        

        getList();

   // })();
</script>

@endsection

