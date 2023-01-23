@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Logs</h1>
    <hr>

    <div id="list mb-5"></div>
    <div class="text-center">
        <button id="showMoreBtn" class="btn btn-primary btn-block w-100">Show More</button>
    </div>
</div>

<script type="module">
    import {Template,$q,util,$el} from '/adarna.js';

    const showMoreBtn   = $q('#showMoreBtn').first();
    const list          = $q('#list').first();
    const t             = new Template();

    //(async () => {

        let page = 0;

        /**
        const statusOpt = {
            CLMD:'Customer Claimed',
            PAID:'Paid to Partner'
        };**/

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

                
                reply.data.items.map(row => {
                    
                    let div = t.div({class:'card mb-3'},()=>{

                        //t.div({class:'card-header'},'&nbsp');
                        
                        /*
                        t.div({class:'card-body'},()=>{
                            t.h5({class:'card-title'},row.entry.item_name);
                            t.p({class:'card-text'},()=>{
                                t.txt(util.numFormat.money('PHP',row.amount));
                               // t.txt(statusOpt[row.status]);
                            });
                        });*/
                    });

                    console.log(div,list);
                   //$el.append(div).to(list);
                   
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

