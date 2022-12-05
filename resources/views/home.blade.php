@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-6 text-center m-2">
                            <button id="logsBtn" class="btn btn-warning">Logs</button>
                        </div>
                        <div class="col-md-6 text-center m-2">
                            <button id="scanBtn" class="btn btn-primary">Scan</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script type="module">
    import {$q} from '/adarna.js';

    console.log($q('#scanBtn').first());
    $q('#scanBtn').first().onclick = (e)=>{
        alert('adsad');
        document.location.href = '/scan';
    }

</script>
@endsection
