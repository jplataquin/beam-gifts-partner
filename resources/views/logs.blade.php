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
    const list          = $q('#list').first();
    const t             = new Template();
    //(async () => {

        let page = 0;

        function getList(){
            
            window.FreezeUI();

            window.util.$get('/api/log/list',{
                page: page
            }).then(reply=>{

                window.UnFreezeUI();

                if(!reply.status){
                    alert(reply.message);
                    return false;
                }
                
                if(!reply.data.items.length){
                    showMoreBtn.style.display = 'none';
                    return false;
                }

                
                console.log(list,'asdasd');
                reply.data.items.map(row => {
                    
                    let div = t.div(()=>{
                        t.h3('asdasd');
                    });

                    console.log(div,'here',row.entry.item_name);
                   
                });

                page++;

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

