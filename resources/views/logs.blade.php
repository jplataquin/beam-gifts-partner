@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Logs</h1>
    <hr>
    <div class="row mb-3">
        <div class="col-md-6 form-group">
            <label>ID</label>
            <input class="form-control" id="idFilter"/>
        </div>
        <div class="col-md-6 form-group">
            <label>Status</label>
            <select class="form-control" id="statusFilter">
                <option value=""> - </option>
                <option value="CLMD">Claimed by Customer</option>
                <option value="RELP">Released to Parnter</option>
            </select>
        </div>
    </div>

    <div id="list" class="mb-5"></div>
    <div class="text-center">
        <button id="showMoreBtn" class="btn btn-primary btn-block w-100">Show More</button>
    </div>
</div>

<script type="module">
    import {Template,$q,util,$el} from '/adarna.js';

    const showMoreBtn   = $q('#showMoreBtn').first();
    const list          = $q('#list').first();
    const statusFilter  = $q('#statusFilter').first();
    const idFIlter      = $q('#idFilter').first();

    const t             = new Template();

    //(async () => {

        let page = 0;

        const statusOpt = {
            CLMD:'Customer Claimed',
            RELP:'Released to Partner'
        };

        function clearList(){
            list.innerHTML = '';
            page = 0;
            showMoreBtn.style.display = 'block';
        }

        function getList(){
            
            window.FreezeUI();

            window.util.$get('/api/log/list',{
                page: page,
                limit: 10,
                status: statusFilter.value,
                id: idFilter.value
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
                        let id = ''+row.id;

                        t.div({class:'card-header'},id.padStart(4,0));
                        
                        t.div({class:'card-body'},()=>{
                            t.h5({class:'card-title'},row.entry.item_name);
                            t.p({class:'card-text'},()=>{

                                t.div({class:'row'},()=>{
                                    t.div({class:'col-md-6'},()=>{

                                        t.txt(util.numFormat.money('PHP',row.amount));
                                        t.br();
                                        t.txt('Status: '+statusOpt[row.status]);
                                        t.br();
                                        t.txt(row.created_at);
                                    });
                                    t.div({class:'col-md-6'},()=>{

                                        t.txt('IP: '+row.entry.ip);
                                        t.br();
                                        t.txt('OS/Browser: '+row.entry.os+' / '+row.entry.browser);
                                        t.br();
                                        t.txt('Released at: '+row.realsed_at);
                                    });

                                });

                               
                            });
                        });
                    });

                    $el.append(div).to(list);
                   
                });

                page++;

                console.log(reply.data);


            });
        }


        showMoreBtn.onclick = (e)=>{
            
            getList();
        }
        

        statusFilter.onchange = (e)=>{
            clearList();
            getList();    
        }

        idFilter.onkeyup = (e)=>{
            clearList();
            getList();
        }

        getList();

   // })();
</script>

@endsection

