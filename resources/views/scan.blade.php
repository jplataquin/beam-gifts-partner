@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Scan</h1>
    <div class="row">
        <div class="col-12 text-center">
            <video width="100%" id="vidEl"></video>
        </div>
    </div>
   
    <script type="module">
        import QrScanner from '/qr-scanner.min.js';

        (async () => {

            const vidEl = document.querySelector('#vidEl');

            const qrScanner = new QrScanner(
                vidEl,
                (result) => {

                    let data;

                    try{
                        data = JSON.parse(result.data);
                    }catch(err){

                        alert('ERROR: QR code not recognized');
                        return false;
                    }

                    if(typeof data.item_uid == 'undefined'){

                        alert('ERROR: Invalid QR code data');
                        return false;
                    }

                    document.location.href = '/claim/'+data.item_uid;
                 
                },
                { /* your options or returnDetailedScanResult: true if you're not specifying any other options */ 
                    highlightScanRegion: true
                },
            );

            let check = await QrScanner.hasCamera();

            if(!check){
                alert('Unable to open camera');
                return false;
            }

            try{
                qrScanner.start(); 
            }catch(err){
                console.log(err);
                alert('ERROR: '+err.message);
            };
            

        })();
        
    </script>
</div>
@endsection
