@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Scan</h1>
    <video id="vidEl"></video>
    <script type="module">
        import QrScanner from '/qr-scanner.min.js';

        (async () => {

            const vidEl = document.querySelector('#vidEl');

            const qrScanner = new QrScanner(
                vidEl,
                (result) => {
                    alert('decoded qr code:', result)
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
